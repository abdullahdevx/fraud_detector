<?php
namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Entity;

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
        ]);
        $sanctumToken = $user->createToken('userToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $sanctumToken,
            'message' => 'Registered Successfully',
        ];

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
}