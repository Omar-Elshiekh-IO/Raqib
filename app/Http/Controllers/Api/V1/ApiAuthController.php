<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;


/**
 * @OA\Info(
 *     title="Raqib Api",
 *     version="1.0.0",
 *     description="API documentation for My App",
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Local development server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */


class ApiAuthController extends Controller
{
  /**
 * @OA\Post(
 *     path="/api/v1/login",
 *     summary="Login user and get token",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login successful",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Login successful"),
 *             @OA\Property(property="user", type="object"),
 *             @OA\Property(property="token", type="string", example="1|sometokenvalue"),
 *             @OA\Property(property="token_type", type="string", example="Bearer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Invalid credentials",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 @OA\Property(property="email", type="array", @OA\Items(type="string", example="Invalid credentials"))
 *             )
 *         )
 *     )
 * )
 */
    public function login(Request $request): JsonResponse
{
    $credentials = $request->validate([
        'email' => "required|email|max:255",
        'password' => "required|string|max:255",
    ]);

    if (!Auth::attempt($credentials)) {
        throw ValidationException::withMessages([
            'email' => "Invalid credentials"
        ]);
    }

    $user = Auth::user();

    // Load employee + branch + company in one go
    $user->load('employee.branch');

    $employee = $user->employee;
    $branch = $employee->branch ?? null;

    $token = $user->createToken(
        name: 'auth-token',
        abilities: ['*'],
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
