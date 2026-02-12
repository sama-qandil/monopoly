<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceLoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function deviceLogin(DeviceLoginRequest $request)
    {

        //TODO: these data is default for the model, better using (model attributes)
        $user = User::firstOrCreate(['device_id' => $request->validated()['device_id']], [
            //TODO: this should be unique , how to avoid collesion ? 
            'username' => 'User' . time(),
            
        ]);

        $token = $user->createToken('device_token')->plainTextToken;

        return $this->success([
            'user'    => new \App\Http\Resources\UserResource($user),
            'token'   => $token,
        ],'Logged in successfully');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:40',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);


        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'device_id' => Str::random(32),
           
        ]);

        $token = $user->createToken('device_token')->plainTextToken;
        return $this->success([
            'user'    => new \App\Http\Resources\UserResource($user),
            'token'   => $token,
        ],'User registered successfully');
    }


    public function LinkAccount(Request $request)
    {
        $user = $request->user();
        if ($user->email) {
            return $this->error('Account already linked to an email', 400);
        }

        $validateduser = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'provider_id' => 'string|nullable'
        ]);
        $user->update([
            'email'       => $validateduser['email'],
            'password'    => Hash::make($validateduser['password']),
            'provider_id' => $validateduser['provider_id'] ?? $user->provider_id
        ]);
        return $this->success([ 'user' => new \App\Http\Resources\UserResource($user)],'Account linked successfully');
    }





    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $validated['email'])->first();
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return $this->error( 'Invalid credentials', 401);
        }

        $token = $user->createToken('device_token')->plainTextToken;
        return $this->success([
             'user' => new \App\Http\Resources\UserResource($user),
            'token'   => $token,
        ],'Logged in successfully');
    }
    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();
        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'username'      => $socialUser->getName(),
                'provider_id'   => $socialUser->getId(),
                'provider_name' => $provider,
                'avatar'        => $socialUser->getAvatar(),
               
            ]
        );

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success(['token' => $token, 'user'    => new \App\Http\Resources\UserResource($user),]);
    }
}
