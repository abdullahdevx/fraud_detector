<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Exception;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Entity;
use App\Models\Review;


class userController extends Controller
{
    public function fetchData()
    {
        $entities = Entity::all();
        $data = $entities->map(function ($entity) 
        {
         return [
        'id' => $entity->id,
        'title' => $entity->title,
        'picture' => $entity->picture,
        'totalRating' => $entity->getTotalRating(),
        'totalReviews' => $entity->totalReviews(),
        ];
        });

        return response()->json(['data' => $data], 200);   
    }

    public function showEntity($id)
    {
        //rendering entity for the modal
        try{
        $entity = Entity::find($id);
         if(!$entity)
        {
            return response()->json(['error' => 'Entity not Found'], 404);
        }
        $data = [
            'id' => $entity->id,
            'title' => $entity->title,
            'picture' => $entity->picture,
            'description' => $entity->description,
            'url' => $entity->url,
            'totalRating' => $entity->getTotalRating(),
            'totalReviews' =>$entity->totalReviews(),
        ];

        $reviews = Review::with('userBelongsTo', 'entityBelongsTo')->where('entity_id', $id)->get();
       
        return response()->json(['data' => $data, 'review' => $reviews], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showAccountData(Request $request)
    {
        $user = $request->user();
        $userID = $user->id;
        $user = User::findOrFail($userID);
        $userName = $user->name;
        $userEmail = $user->email;
        $userImage = $user->user_image;
        $image = $userImage;
         return response()->json([
        'id' => $userID,
        'name' => $userName,
        'email' => $userEmail,
        'image' => $image,
         ], 200);
    }

    public function addReview(Request $request)
    {   
        $user = $request->user();
        $rating1 = $request->input('rating');
        $entityID = $request->input('entity_id');
        $review1 = $request->input('review');
         // Check if the user has already reviewed this entity
        $existingReview = Review::where('user_id', $user->id)->where('entity_id', $entityID)->first();
        if($existingReview) {
             return response()->json(['error' => 'You have already reviewed this entity'], 409);
         }
         elseif($user->email_verified_at == null)
         {          
            return response()->json(['error' => 'UnAuthorized'], 401);
         }
         else
         {
        $review = new Review;
        $review->user_id = $user->id;
        $review->entity_id = $entityID;
        $review->rating = $rating1;
        $review->comment = $review1;
        $review->save();
        return response()->json(['success' => 'Review Added Successfully'], 201);
    }
    }

    public function changePicture(Request $request)
    {
        $user = $request->user();
        $userID = $user->id;        
        $user = User::findOrFail($userID);
        $path = $request->file('image')->store('profile_picture', 'public');
        $user->user_image = asset('storage/'. $path);
        $user->save();
        return response()->json(['success' => 'Updated Successfully'], 201);
    }

       
    public function search(Request $request)
{
    $query = $request->input('query'); 
    $entities = Entity::where('title', 'like', '%'.$query.'%')->get();

    if (!$entities->isEmpty()) {
        $data = [];

        if ($entities->count() === 1) {
            $entity = $entities->first(); // Get the first entity
            $data[] = [
                'id' => $entity->id,
                'title' => $entity->title,
                'picture' => $entity->picture,
                'totalRating' => $entity->getTotalRating(),
                'totalReviews' => $entity->totalReviews(),
            ];
        } else {
            // If more than one entity found
            $data = $entities->map(function ($entity) {
                return [
                    'id' => $entity->id,
                    'title' => $entity->title,
                    'picture' => $entity->picture,
                    'totalRating' => $entity->getTotalRating(),
                    'totalReviews' => $entity->totalReviews(),
                ];
            });
        }

        return response()->json(['data' => $data], 200);
    } else {
        return response()->json(['error' => 'Entity not found'], 404);
    }
}
    }