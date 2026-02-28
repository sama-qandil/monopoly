<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopItemResource extends JsonResource
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
            'category' => $this->category,
            'price' => $this->price,
            'currency_type' => $this->currency_type,
            'is_active' => $this->is_active,
            'discount_percentage' => $this->discount_percentage,
            'final_price' => $this->price - ($this->price * ($this->discount_percentage / 100)),
            'item_details' => $this->resolveItemResource(),
        ];
    }

    protected function resolveItemResource()
    {
       
        if (!$this->itemable) {
            return null;
        }

        return match ($this->category) {
            'characters' => new characterResource($this->itemable),
            'dices'      => new DiceResource($this->itemable),
            'necklaces'  => new NecklaceResource($this->itemable),
            'gold'       => new GoldResource($this->itemable),
            default      => $this->itemable,        
        };
    }
}
