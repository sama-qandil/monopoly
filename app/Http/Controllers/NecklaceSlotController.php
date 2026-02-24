<?php

namespace App\Http\Controllers;

use App\Models\NecklaceSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NecklaceSlotController extends Controller
{
    public function buySlot(Request $request, $slotId)
    {
        $user = $request->user();
        $slot = NecklaceSlot::findOrFail($slotId);

        if ($user->level < $slot->required_level) {
            return $this->error("you must be level {$slot->required_level} to unlock this slot");
        }

        if ($user->unlockedSlots()->where('necklace_slot_id', $slotId)->exists()) {
            return $this->error('this slot is already unlocked');
        }

        if ($user->gems < $slot->price) {
            return $this->error('not enough gems');
        }

        DB::transaction(function () use ($user, $slot) {
            $user->decrement('gems', $slot->price);
            $user->unlockedSlots()->attach($slot->id);
        });

        return $this->success(null, 'slot unlocked successfully');
    }
}
