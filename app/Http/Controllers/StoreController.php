<?php

// app/Http/Controllers/Api/StoreController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\characterResource;
use App\Http\Resources\DiceResource;
use App\Http\Resources\NecklaceResource;
use App\Http\Resources\GoldResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Character;
use App\Models\Dice;
use App\Models\Necklace;
use App\Models\Gold;
use App\Models\Jewelry;

class StoreController extends Controller {

public function getitemByCategory(Request $request, $category) {
    $data=match($category){
        'characters'=>Character::all(),
        'dices'=>Dice::all(),
        'necklaces'=>Necklace::all(),
        'gold'=>Gold::all(),
        'jewelries'=>Jewelry::all(),
        default => null,

    };
    return $this->success($data,"Items of category $category retrieved successfully");
}


public function getitemDetails(Request $request, $category, $id) {
    $data=match($category){
        'characters'=>Character::query(),
        'dices'=>Dice::query(),
        'necklaces'=>Necklace::query(),
        'gold'=>Gold::query(),
        'jewelries'=>Jewelry::query(),
        default=> null,

    };
    $item=$data->findOrFail($id);
    return $this->success($item,"Item details retrieved successfully");
}



    public function buyCharacter(Request $request, $id) {
        $user = $request->user(); 
        $character = Character::findOrFail($id);

        
        if ($user->characters()->where('character_id', $id)->exists()) {
            return $this->error(null,'You already own this character!');
        }

        
        $currency=$character-> gold_price > 0  ? 'gold' : 'gems';
        $price=$character->gold_price > 0 ? $character->gold_price : $character->gem_price; 

        if ($user->$currency < $price) {
            return $this->error(null,'your balance is not enough!');
        }
        
        DB::transaction(function () use ($user, $character, $currency, $price) {
           
            $user->decrement($currency, $price);

           
            $user->characters()->attach($character->id, [
                'current_level' => 1,
                'current_experience' => 0,
                'is_selected' => false
            ]);
        });

        
    return $this->success(new characterResource($character),'Character purchased successfully!');

    }



   public function buyDice(Request $request, $id) {
        $user = $request->user(); 
        $dice = Dice::findOrFail($id);

        
        if ($user->dices()->where('dice_id', $id)->exists()) {
            return $this->error(null,'You already own this dice!');
        }

        
       if($user->gems < $dice->gems_cost){
            return $this->error(null,'your balance is not enough!');
        }
      
        
        DB::transaction(function () use ($user, $dice) {
           
            $user->decrement('gems', $dice->gems_cost);

           
            $user->dices()->attach($dice->id);
        });

        return $this->success(new DiceResource($dice),'dice purchased successfully!');
    }


    public function buyNecklaces(Request $request, $id){
        $user=$request->user();
        $necklace=Necklace::findOrFail($id);
        
        if ($user->necklaces()->where('necklace_id', $id)->exists()) {
            return $this->error(null,'You already own this necklace!');
        }

        
        $currency=$necklace-> gold_cost > 0  ? 'gold' : 'gems';
        $price=$necklace->gold_cost > 0 ? $necklace->gold_cost : $necklace->gems_cost; 

        if ($user->$currency < $price) {
            return $this->error(null,'your balance is not enough!');
        }
        
        DB::transaction(function () use ($user, $necklace, $currency, $price) {
           
            $user->decrement($currency, $price);

           
            $user->necklaces()->attach($necklace->id);
        });

        return $this->success(new NecklaceResource($necklace),'Necklace purchased successfully!');
    }



    public function  buyGold(Request $request , $id){
        $user=request()->user();
        $gold=Gold::findOrFail($id);

        if($user->gold()->where('gold_id', $id)->exists()) {
            return $this->error(null,'You already own this gold package!');
        }

        if($user->gems < $gold->price){
            return $this->error(null,'your balance is not enough!');
        }

        DB::transaction(function () use ($user, $gold) {
            $user->decrement('gems', $gold->gems_cost);
            $user->increment('gold', $gold->gold);
        });

        return $this->success(new GoldResource($gold),'Gold purchased successfully!');
    }
    




}