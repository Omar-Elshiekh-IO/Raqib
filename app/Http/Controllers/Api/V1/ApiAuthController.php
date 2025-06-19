<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ApiAuthController extends Controller
{
    public function login(Request $request):JsonResponse{
      
      $credentials = $request->validate([
        'email' => "required|email|max:255",
        'password' => "required|string|max:255"
      ]);

      if(!Auth::attempt($credentials)){
        throw ValidationException::withMessages([
          'email' => "Invalid credentials"
        ]);
      }

      $user = Auth::user();

      $token = $user->createToken(
        name: 'auth-token',
        abilities: ['*'],
        expiresAt: now()->addDays(30)
      )->plainTextToken;


      return response()->json([
            'message' => 'Login successful',
            'user' => new UserResource($user),
            'token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    // public function logout(Request $request):JsonResponse{
    //   $request->user()->currentAccessToken()->delete();

    //   return response()->json(['message' => 'Logged out successfully']);
    // }
}
