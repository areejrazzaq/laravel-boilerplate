<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends AppBaseController
{
    public function login(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $result['token'] = $this->tokenFromUser($user);
            $result['email'] = $user->email;
            $result['name'] = $user->name;
            $result['role'] = $user->roles->pluck('name')[0];
            return response($result);
        }
        return response(['message' => 'Invalid Credentials'], 401);
    }

    public function register(Request $request)
    {
        $fields = ['name','email','password','password_confirmation','role'];
        $credentials = $request->only($fields);

        $validator = Validator::make(
            $credentials,
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|string|confirmed|min:8',
                'role' => 'required',
            ]
        );
        if ($validator->fails()) {
            return $this->sendError_v2('Validation Failed', $validator->messages());
        }
        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password']),
        ]);
        $user->assignRole($credentials['role']);
        $user['token'] = $this->tokenFromUser($user);

        return $this->sendResponse($user->only(['email', 'token', 'id']), 'User registered successfully.');
    }

    public function logout(): JsonResponse
    {
        try {

            Auth::logout();
            return $this->sendSuccess('User logged out successfully.');
        } catch (Exception $e) {
            return $this->sendError('Error while logging out.');
        }
    }

    public function tokenFromUser(User $user)
    {
        Auth::shouldUse('api');
        // logs in the user
        Auth::guard('web')->loginUsingId($user->id);

        // get and return a new token
        $token = $user->createToken('Laravel Access Token')->accessToken;
        return $token;
    }
}
