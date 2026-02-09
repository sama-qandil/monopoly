<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller

{
    public function register(Request $request){
        $request->validate([
            'name' =>'required|string|max:255',
            'email' =>'required|string|email|max:255|unique:users,email',
            'password' =>'required|string|min:8|confirmed',
            ]);
            User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]);
            return response()->json(['message'=>'User registered successfully'],201);

    }



    public function login(Request $request)
{
      $request->validate([
          
            'email' =>'required|string|email',
            'password' =>'required|string|min:8',
            ]);
            if(!Auth::attempt($request->only('email','password'))){
                return response()->json(['message'=>'Invalid login details'],401);
            }
            $user=User::where('email',$request->email)->firstorFail();
            $token=$user->createToken('auth_token')->plainTextToken;
            return response()->json(['message'=>'User logged in successfully'],201);


}
    public function logout(Request $request)
    {

    }



}