<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            if (!Auth::attempt($credentials)) {
                return response(['message' => 'Email or password is not correct']);
            }
            $user = Auth::user();
            $token = $user->createToken('main')->plainTextToken;
            return response(compact('user', 'token'));
        } catch (\Exception $exception) {
            Log::error("Error " . $exception->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function signup(SignupRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password'])
            ]);
            $token = '';
            if ($user) {
                $token = $user->createToken('main')->plainTextToken;
            }
            return response(compact('user', 'token'));
        } catch (\Exception $exception) {
            Log::error("Error " . $exception->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            if ($request) {
                /* @var User $user */
                $user = $request->user();
                $user->currentAccessToken()->delete();
                return response('', 204);//succeeded but nothing to return
            }
        } catch (\Exception $exception) {
            Log::error("Error " . $exception->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
}

