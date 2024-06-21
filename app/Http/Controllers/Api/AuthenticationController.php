<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

class AuthenticationController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            // Define validation rules
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:1|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);

            // Check validation results
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Create user if validation passes
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                'user' => $user,
                'token' => $user->createToken('passportToken')->accessToken
            ], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], config('constants.VALIDATION_ERROR'));
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to register user'], constants::VALIDATION_ERROR);
        }
    }

    /**
     * Login an existing user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            // Define validation rules
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            // Check validation results
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Attempt to log in the user
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $token = Auth::user()->createToken('passportToken')->accessToken;

                return response()->json([
                    'user' => Auth::user(),
                    'token' => $token
                ], 200);
            }

            return response()->json([
                'error' => 'Unauthorized - Email or password is incorrect'
            ], config('constants.UNAUTHORIZED_ERROR'));
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], config('constants.VALIDATION_ERROR'));
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to log in'], config('constants.INERNAL_SERVER_ERROR'));
        }
    }

    /**
     * Logout the currently authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();

            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to log out'], config('constants.INERNAL_SERVER_ERROR'));
        }
    }
}
