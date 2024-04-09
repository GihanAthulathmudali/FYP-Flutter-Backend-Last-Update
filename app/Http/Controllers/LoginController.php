<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Crop;
use App\Models\Disease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function register(Request $request)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email', // Ensure email is unique in the 'users' table
        'password' => 'required|string',
    ]);

    // Check if the email already exists
    $existingUser = User::where('email', $validatedData['email'])->first();
    if ($existingUser) {
        return response()->json(['message' => 'Email already exists'], 201);
    }

    // If the email doesn't exist, proceed to create the user
    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        'role' => 'user'
    ]);
    $token = $user->createToken('authToken')->plainTextToken;
    return response()->json(['user' => $user, 'token' => $token, 'message' => 'User registered successfully'], 200);
}


    public function login(Request $request)
{
    $validatedData = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $validatedData['email'])->first();

    if (!$user || !Hash::check($validatedData['password'], $user->password)) {
        return response()->json(['message' => 'Invalid credentials']);
    }

    $token = $user->createToken('authToken')->plainTextToken;

    return response()->json(['user' => $user, 'token' => $token, 'message' => 'Login successful']);
}

   public function getUserData() {
    $user = auth()->user();

    if ($user) {
        // User found, return user data
        return response()->json(['user' => $user, 'message' => 'User data retrieved successfully'], 200);
    } else {
        // User not found
        return response()->json(['message' => 'User not found'], 404);
    }
}


    
}
