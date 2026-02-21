<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'description' => $this->description,
            'target_count' => $this->target_count,
            'reward_gold' => $this->reward_gold,
            'reward_gems' => $this->reward_gems,
            'reward_points' => $this->reward_points,
        ];
    }
}
