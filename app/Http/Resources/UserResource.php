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
            'id'=>$this->id,
            'username'=>$this->username,
            'email'=>$this->email,
            'country'        => $this->whenLoaded('country', function() {
                return [
                    'name' => $this->country->name,
                    'flag' => $this->country->flag_code,
                ];
            }),
            'level' => $this->level,
            'favorite_character' => $this->whenLoaded('favoriteCharacter', function(){
                return[
                    'name' => $this->favoriteCharacter?->name,
                    'avatar' => $this->favoriteCharacter?->avatar,
                ];
            }),

           'stats' => [
    'total_matches'    => $this->total_matches,
    'wins'             => $this->wins,
    'loses'            => $this->loses,
    'gold'             => $this->gold,
    'gems'             => $this->gems,
    'necklaces_count'  => $this->necklaces_count , 
    'dice_count'       => $this->dices_count , 
    'characters_count' => $this->characters_count ,
],
        ];
    }
}
