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
        return [
            'name' => $this->username,
            'email' => $this->email,
            'country' => new CountryResource($this->whenLoaded('country')),
            

            'favorite_character' => new CharacterResource($this->whenLoaded('favoriteCharacter')),

            'stats' => [
                'total_matches' => $this->total_matches,
                'wins' => $this->wins,
                'loses' => $this->loses,
                'gold' => $this->gold,
                'gems' => $this->gems,
                'necklaces_count' => $this->necklaces_count ?? 0,
                'dice_count' => $this->dices_count ?? 0,
                'characters_count' => $this->characters_count ?? 0,
            ],
        ];
    }
}
