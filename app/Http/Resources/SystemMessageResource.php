<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SystemMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'delivered_at' => $this->delivered_at,
            'is_read' => $this->pivot->is_read ?? false, 
        ];
    }
}
