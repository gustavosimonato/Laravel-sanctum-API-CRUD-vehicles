<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Throwable;
use Illuminate\Contracts\Auth\Authenticatable;

class AuthService
{
    /**
     * @param array $data
     * @return array
     * @throws Throwable
     */
    public function register(array $data): array
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

            return ['token' => $token];
        } catch (Throwable $throw) {
            DB::rollBack();
            throw $throw;
        }
    }

    /**
     * @param array $credentials
     * @return array
     * @throws Throwable
     * @throws ValidationException
     */
    public function login(array $credentials): array
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

            return ['token' => $token];
        } catch (Throwable $throw) {
            DB::rollBack();
            throw $throw;
        }
    }

    /**
     * @param Authenticatable $user
     * @return string[]
     * @throws Throwable
     */
    public function logout(Authenticatable $user): array
    {
        try {
            DB::beginTransaction();

            $user->currentAccessToken()->delete();

            DB::commit();

            return ['message' => 'Successfully logged out'];
        } catch (\Throwable $throw) {
            DB::rollBack();
            throw $throw;
        }
    }
}
