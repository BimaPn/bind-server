<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    public function store(LoginRequest $request)
    {
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'id' => auth()->user()->id,
            'name' =>  auth()->user()->name,
            'username' => auth()->user()->username,
            'email' => auth()->user()->email,
            'isVerified' => auth()->user()->isVerified(),
            'role' => auth()->user()->role->type,
            'profile_picture' => auth()->user()->profile_picture,
        ]);
    }
}
