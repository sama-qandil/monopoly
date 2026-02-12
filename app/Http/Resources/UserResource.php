<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'name'=>$this->username,
            'email'=>$this->email,
            'country' => $this->country ? $this->country->name : null,
            'avatar'=>$this->avatar,
            'gold'=>$this->gold,
            'gems'=>$this->gems,
            'current_experience'=>$this->current_experience,
            'wins'=>$this->wins,
            'loses'=>$this->loses,
            'total_matches'=>$this->total_matches,
            'favorite_character'=>$this->favoriteCharacter ? $this->favoriteCharacter->name : null
        ];
    }
}
