<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NecklaceResource extends JsonResource
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
            'name'=>$this->name,
            'description'=>$this->description,
            'classification'=>$this->classification,
            'gold_cost'=>$this->gold_cost,
            'gems_cost'=>$this->gems_cost,
            'icon_url'=>$this->icon,

        ];
        
    }
}
