<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

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
