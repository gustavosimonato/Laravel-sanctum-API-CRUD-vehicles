<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Throwable;

class AuthService
{
    /**
     * @param array $data
     * @return JsonResponse
     */
    public function register(array $data): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $token = $user->createToken('authToken')->plainTextToken;

            DB::commit();

            return response()->json([
                'message' => 'User registered successfully',
                'token' => $token,
            ], Response::HTTP_CREATED);
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json(
                ['error' => 'Failed to register user.'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param array $credentials
     * @return JsonResponse
     */
    public function login(array $credentials): JsonResponse
    {
        try {
            DB::beginTransaction();

            if (!Auth::attempt($credentials)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $user = Auth::user();

            // Logout others devices
            $user->tokens()->delete();

            $token = $user->createToken('authToken')->plainTextToken;

            DB::commit();

            return response()->json(
                ['token' => $token],
                Response::HTTP_OK
            );
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json(
                ['error' => 'Failed to login.'],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $request->user()->currentAccessToken()->delete();

            DB::commit();

            return response()->json(
                ['message' => 'Successfully logged out'],
                Response::HTTP_OK
            );
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json(
                ['error' => 'Failed to logout.'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
