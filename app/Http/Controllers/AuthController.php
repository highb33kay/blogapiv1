<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// use sanctum
use Laravel\Sanctum\HasApiTokens;


class AuthController extends Controller
{
    // Register a new user
	public function register(Request $request)
	{
		$id = Str::uuid();
		// Validate request
		$validator = Validator::make($request->all(), [
			'name' => 'required|string',
			'email' => 'required|email|unique:users,email',
			'password' => 'required|string',
		]);

		// print hello to the console
		print("hello");

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()], 400);
		}

		// Store a new user
		$user = new User();
		$user->id = $id;
		$user->name = $request->name;
		$user->email = $request->email;

		// Hash the password before saving it to the database
		$user->password = Hash::make($request->password);

		$user->save();

		// Create a token for the user
		$token = $user->createToken('auth_token')->plainTextToken;

		// Return a response with the token
		return response()->json([
			'success' => true,
			'data' => [
				'token' => $token,
				'token_type' => 'Bearer',
			],
		], 201);
	}

	// Login an existing user
	public function login(Request $request)
	{
		// Validate request
		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required|string',
		]);

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()], 400);
		}

		// Check if the user exists
		$user = User::where('email', $request->email)->first();

		// If the user doesn't exist
		if (!$user) {
			return response()->json([
				'success' => false,
				'message' => 'Invalid login details',
			], 401);
		}

		// If the credentials are wrong
		if (!Hash::check($request->password, $user->password)) {
			return response()->json([
				'success' => false,
				'message' => 'Invalid login details',
			], 401);
		}

		// Create a token for the user
		$token = $user->createToken('auth_token')->plainTextToken;

		// Return a response with the token
		return response()->json([
			'success' => true,
			'data' => [
				'token' => $token,
				'token_type' => 'Bearer',
			],
		], 200);
	}

	// Logout an existing user
	public function logout(Request $request)
	{
		// Revoke all tokens...
		$request->user()->tokens()->delete();

		return response()->json([
			'success' => true,
			'message' => 'Logout successful',
		], 200);
	}

	// Get an authenticated user
	public function user(Request $request)
	{
		
		return response()->json([
			'success' => true,
			'data' => $request->user(),
		], 200);
	}

}
