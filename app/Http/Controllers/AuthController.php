<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
class AuthController extends Controller
{
    public function deviceLogin(Request $request){
        $request->validate([
            'device_id'=>'required|string']);

            $user=User::firstOrCreate(['device_id'=>$request->device_id],[
                'username'=>'User'.Str::random(5),
                'gold'=>'0',
                'gems'=>'0',
                'avatar'=>'default.png',
                'total_matches'=>'0',
                'wins'=>'0',
                'losses'=>'0',
            ]);

            $token = $user->createToken('device_token')->plainTextToken;

    return response()->json([
        'message' => 'Logged in successfully',
        'user'    => $user,
        'token'   => $token,
    ], 200);
    }

    public function register(Request $request){
        $validated=$request->validate([
            'username'=>'required|string|max:40',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:6',
        ]);
            

            $user = User::create([
                'username'=>$validated['username'],
                'email'=>$validated['email'],
                'password'=>Hash::make($validated['password']),
                'device_id'=>Str::random(32),
                'gold'=>'0',
                'gems'=>'0',
                'avatar'=>'default.png',
                'total_matches'=>'0',
                'wins'=>'0',
                'losses'=>'0',
            ]);

            $token = $user->createToken('device_token')->plainTextToken;
            return response()->json([
        'message' => 'User registered successfully',
        'user'    => $user,
        'token'   => $token
    ], 201);
}


public function LinkAccount(Request $request){
    $user=$request->user();
    if($user->email){
        return response()->json(['message'=>'Account already linked to an email'],400);
    }

    $validateduser=$request->validate([
        'email'=>'required|email|unique:users,email',
        'password'=>'required|string|min:6',
        'provider_id'=>'string|nullable'
    ]);
    $user->update($validateduser);
    return response()->json(['message'=>'Account linked successfully','user'=>$user],200);
}





public function login(Request $request){
    $validated=$request->validate([
        'email'=>'required|email',
        'password'=>'required|string|min:6',
    ]);

    $user=User::where('email',$validated['email'])->first();
    if(!$user || !Hash::check($validated['password'],$user->password)){
        return response()->json(['message'=>'Invalid credentials'],401);
    }

    $token = $user->createToken('device_token')->plainTextToken;
    return response()->json([
        'message' => 'Logged in successfully',
        'user'    => $user,
        'token'   => $token,
    ], 200);    


}
    public function handleProviderCallback($provider){
        $socialUser=Socialite::driver($provider)->user();
        $user=User::firstOrCreate(
        ['email' => $socialUser->getEmail()],
        [
            'username'      => $socialUser->getName(),
            'provider_id'   => $socialUser->getId(),
            'provider_name' => $provider,
            'avatar'        => $socialUser->getAvatar(),
            'gold'=>'0',
            'gems'=>'0',
            'total_matches'=>'0',
            'wins'=>'0',
            'losses'=>'0',
        ]
    );

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json(['token' => $token, 'user' => $user]);

    }






}