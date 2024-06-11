<?php
namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Entity;
use App\Mail\VerificationEmail;
use Carbon\Carbon;

class authController extends Controller
{
    public function register(Request $request)
    {
        try {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|ends_with:@gmail.com|unique:users',
            'password' => 'required',
        ]);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'verification_token' => Str::random(60),
        ]);
        $sanctumToken = $user->createToken('userToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $sanctumToken,
            'message' => 'Registered Successfully',
        ];
        Mail::to($user->email)->send(new VerificationEmail($user));
        return response($response, 201);
    }
    catch (\ValidationException $e) {
        return response(['errors' => $e->errors()], 422);
    }
}

    
    public function login(Request $request)
    {
        $credientials = $request->only('email', 'password');

        if(Auth::attempt($credientials))
        {
            $user = Auth::user();
            $sanctumToken = $user->createToken('userToken')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $sanctumToken,
             ];
            return response()->json($response, 200);
        }
        else
        {
            $response = ['status' => 'Invalid Credientials'];
            return response($response, 401);
        }
    }

    public function logoutUser(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(['message' => 'LOGGED OUT Successfully'], 200);
    }

    public function verifyEmail(Request $request, $token)
    {
        $verificationToken = $token;
        $user = User::where('verification_token', $verificationToken)->first();
        $user->email_verified_at = now();
        $user->save();
        return view('emails.thankyou');
    }

}