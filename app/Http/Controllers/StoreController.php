<?php

// app/Http/Controllers/Api/StoreController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Character;
use App\Models\Dice;
use App\Models\Necklace;
use App\Models\Gold;

class StoreController extends Controller {

    public function buyCharacter(Request $request, $id) {
        $user = $request->user(); 
        $character = Character::findOrFail($id);

        
        if ($user->characters()->where('character_id', $id)->exists()) {
            return response()->json(['message' => 'You already own this character!'], 400);
        }

        
        $currency=$character-> gold_price > 0  ? 'gold' : 'gems';
        $price=$character->gold_price > 0 ? $character->gold_price : $character->gem_price; 

        if ($user->$currency < $price) {
            return response()->json(['message' => 'your balance is not enough!'], 400);
        }
        
        DB::transaction(function () use ($user, $character, $currency, $price) {
           
            $user->decrement($currency, $price);

           
            $user->characters()->attach($character->id, [
                'current_level' => 1,
                'current_experience' => 0,
                'is_selected' => false
            ]);
        });

        return response()->json(['message' => 'Character purchased successfully!', 'remaining_gold' => $user->gold]);
    }



   public function buyDice(Request $request, $id) {
        $user = $request->user(); 
        $dice = Dice::findOrFail($id);

        
        if ($user->dices()->where('dice_id', $id)->exists()) {
            return response()->json(['message' => 'You already own this dice!'], 400);
        }

        
       if($user->gems < $dice->gems_cost){
            return response()->json(['message' => 'your balance is not enough!'], 400);
        }
      
        
        DB::transaction(function () use ($user, $dice) {
           
            $user->decrement('gems', $dice->gems_cost);

           
            $user->dices()->attach($dice->id);
        });

        return response()->json(['message' => 'dice purchased successfully!', ]);
    }

    public function buyNecklaces(Request $request, $id){
        $user=$request->user();
        $necklace=Necklace::findOrFail($id);
        
        if ($user->necklaces()->where('necklace_id', $id)->exists()) {
            return response()->json(['message' => 'You already own this necklace!'], 400);
        }

        
        $currency=$necklace-> gold_price > 0  ? 'gold' : 'gems';
        $price=$necklace->gold_price > 0 ? $necklace->gold_cost : $necklace->gems_cost; 

        if ($user->$currency < $price) {
            return response()->json(['message' => 'your balance is not enough!'], 400);
        }
        
        DB::transaction(function () use ($user, $necklace, $currency, $price) {
           
            $user->decrement($currency, $price);

           
            $user->necklaces()->attach($necklace->id);
        });

        return response()->json(['message' => 'Necklace purchased successfully!', ]);
    }



    public function  buyGold(Request $request , $id){
        $user=request()->user();
        $gold=Gold::findOrFail($id);

        if($user->golds()->where('gold_id', $id)->exists()) {
            return response()->json(['message' => 'You already own this gold package!'], 400);
        }

        if($user->gems < $gold->price){
            return response()->json(['message' => 'your balance is not enough!'], 400);
        }

        DB::transaction(function () use ($user, $gold) {
            $user->decrement('gems', $gold->gems_cost);
            $user->golds()->attach($gold->id);
        });

        return response()->json(['message' => 'Gold purchased successfully!', 'remaining_gems' => $user->gems]);
    }
    




}