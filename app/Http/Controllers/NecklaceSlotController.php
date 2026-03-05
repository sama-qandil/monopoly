<?php

namespace App\Http\Controllers;

use App\Models\NecklaceSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NecklaceSlotController extends Controller
{
//    public function buySlot(Request $request, $slotNumber)
// {
//     $user = $request->user();

//     // 1. البحث عن السلوت بناءً على رقمه (Slot Number)
//     $slot = NecklaceSlot::where('slot_number', $slotNumber)->first();

//     if (!$slot) {
//         return $this->error("This slot number does not exist.", 404);
//     }

//     // 2. حساب عدد السلوتات اللي اليوزر فتحها فعلياً
//     $unlockedSlotsCount = $user->unlockedSlots()->count();
//     $maxSlotsInGame = NecklaceSlot::count();

//     // 3. التحقق إذا كان اللاعب وصل للحد الأقصى للسلوتات المفتوحة
//     if ($unlockedSlotsCount >= $maxSlotsInGame) {
//         return $this->error("You have already unlocked the maximum number of slots.");
//     }

    

//     if ($slotNumber != ($unlockedSlotsCount + 1)) {
//         return $this->error("You must unlock slot number " . ($unlockedSlotsCount + 1) . " first.");
//     }

    
//     if ($user->unlockedSlots()->where('slot_number', $slotNumber)->exists()) {
//         return $this->error('This slot is already unlocked.');
//     }

//     if ($user->level < $slot->required_level) {
//         return $this->error("You must be level {$slot->required_level} to unlock this slot.");
//     }

//     if ($user->gems < $slot->price) {
//         return $this->error('Not enough gems.');
//     }

//     DB::transaction(function () use ($user, $slot) {
//         $user->decrement('gems', $slot->price);
//         $user->unlockedSlots()->attach($slot->id);
//     });

//     return $this->success(null, "Slot number {$slotNumber} unlocked successfully!");
// }


public function buySlot(Request $request, $slotNumber)
{
    $user=$request->user();

    $slot=NecklaceSlot::where('slot_number',$slotNumber)->first();

    if(!$slot)
        {
            return $this->error('this slot number does not exist',404);
        }

    if($user->level < $slot->required_level){
        return $this->error('you must reach level'.$slot->required_level. 'to unlock this slot');
    }

    $price=$slot->price;

    if($user->{$slot->currency_type->value} <$price)
        {
            return $this->error('your balance is not enough');
        }

    $unlockedSlotsCount=$user->unlockedSlots()->count();

    if($unlockedSlotsCount >= 5)
            {
                return $this->error('you have already unlock all the slots');
            }

    if($slotNumber !=($unlockedSlotsCount+1))
            {
                return $this->error('you must unlock slot number '.($unlockedSlotsCount+1).' first');
            }
    if($user->unlockedSlots()->where('slot_number',$slotNumber)->exists())
            {
                return $this->error('this slot is already unlocked');
            }

    DB::transaction(function()use($user,$slot,$price){
        $user->decrement($slot->currency_type->value, $price);
        $user->unlockedSlots()->attach($slot->id);
    });

    return $this->success(null, "Slot number {$slotNumber} unlocked successfully!");
}
}
