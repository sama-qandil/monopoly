<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
class UserController extends Controller

{
  public function profile(Request $request)
{
    $user = $request->user();

 
    $user->loadCount(['necklaces', 'dices', 'characters']); 


    $user->load(['country', 'favoriteCharacter']);

    return $this->success(new UserResource($user), 'user data retrieved successfully');
}
} 