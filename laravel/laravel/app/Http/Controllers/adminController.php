<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Exception;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Review;
use App\Models\Entity;             

class adminController extends Controller
{
    public function checkRole(Request $request)
    {
        $user = $request->user();
        if($user->role == 1)
    {
        return response()->json(['status' => 'Authorized'], 200);

    }
    elseif($user->role == 0)
    {
        return response()->json(['status' => 'UnAuthorized'], 401);
    }

    }
    public function createEntity(Request $request)
    {
        try {
        $entity = new Entity;
        $entity->title = $request->input('title');
        $entity->description = $request->input('description');
        //storing file in images using storage:link
        $path = $request->file('image')->store('images', 'public');
        $entity->picture = asset('storage/'. $path);
        $entity->url = $request->input('url');
        $entity->save();
        return response()->json(['status' => 'Entity Created Successfully'], 201);   
         }
         catch(\Exception $e)
         {
            return response()->json(['error' => $e->getMessage()], 500);
         }
    }



    public function deleteEntity($id)
    {
        try{
        $entity = Entity::findOrFail($id);
        $entity->delete();
        return response()->json(['status' => 'Deleted Successfully'], 200);
        } 
        catch(\Exception $e) {
        return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function editEntity(Request $request, $id)
    {
        try{
        $entity = Entity::find($id);
        $entity->title = $request->input('title');
        $entity->description = $request->input('description');
        $entity->overall_rating = $request->input('overall_rating');
        $entity->url = $request->input('url');
        return response()->json(['status' => 'Edited Successfully', 200]);
        }
        catch(\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showEntity(Request $request, $id)
    {
        try{
        $entity = Entity::find($id);
        $response = [
            'entity' => $entity,
        ];
        return response($response, 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
?>