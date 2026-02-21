<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipNecklaceRequest;
use App\Models\EquippedNecklace;
use App\Http\Requests\StoreEquippedNecklaceRequest;
use App\Http\Requests\UpdateEquippedNecklaceRequest;

class EquippedNecklaceController extends Controller
{
    public function equip(EquipNecklaceRequest $request)
{
    $validated = $request->validated();

    $user = $request->user();

   
    if (!$user->necklaces()->where('necklace_id', $validated['necklace_id'])->exists()) {
        return $this->error(' you do not own this necklace');
    }

   
    if (!$user->unlockedSlots()->where('necklace_slot_id', $validated['slot_id'])->exists()) {
        return $this->error('you must buy this slot first');
    }

   
    $user->equippedNecklaces()->updateOrCreate(
        ['necklace_slot_id' => $validated['slot_id']], 
        ['necklace_id'      => $validated['necklace_id']] 
    );

    return $this->success(null, 'necklace equipped successfully');
}
}