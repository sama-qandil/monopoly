<?php

// app/Http/Controllers/Api/StoreController.php

namespace App\Http\Controllers;

use App\Http\Resources\characterResource;
use App\Http\Resources\DiceResource;
use App\Http\Resources\GoldResource;
use App\Http\Resources\NecklaceResource;
use App\Http\Resources\ShopItemResource;
use App\Models\Character;
use App\Models\Dice;
use App\Models\Gold;
use App\Models\Jewelry;
use App\Models\Necklace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ShopItem;

class StoreController extends Controller
{
    // public function getitemByCategory(Request $request, $category)
    // {
    //     // TODO: use pagination
    //     $data = match ($category) {
    //         'characters' => Character::all(),
    //         'dices' => Dice::all(),
    //         'necklaces' => Necklace::all(),
    //         'gold' => Gold::all(),
    //         'jewelries' => Jewelry::all(),
    //         default => null,

    //     };

    //     // TODO: use resource
    //     return $this->success($data, "Items of category $category retrieved successfully");
    // }

    // public function getitemDetails(Request $request, $category, $id)
    // {
    //     $data = match ($category) {
    //         'characters' => Character::query(),
    //         'dices' => Dice::query(),
    //         'necklaces' => Necklace::query(),
    //         'gold' => Gold::query(),
    //         'jewelries' => Jewelry::query(),
    //         default => null,

    //     };
    //     $item = $data->findOrFail($id);

    //     return $this->success($item, 'Item details retrieved successfully');
    // }

    // public function buyCharacter(Request $request, $id)
    // {
    //     $user = $request->user();
    //     $character = Character::findOrFail($id);

    //     if ($user->characters()->where('character_id', $id)->exists()) {
    //         return $this->error('You already own this character!', 400);
    //     }

    //     $currency = $character->gold_price > 0 ? 'gold' : 'gems';
    //     $price = $character->gold_price > 0 ? $character->gold_price : $character->gems_price;

    //     if ($price > $user->$currency) {
    //         return $this->error('Your balance is not enough!', 400);
    //     }

    //     DB::transaction(function () use ($user, $character, $currency, $price) {

    //         $user->decrement($currency, $price);

    //         $user->characters()->attach($character->id, [
    //             'current_level' => 1,
    //             'current_experience' => 0,
    //             'is_selected' => false,
    //         ]);
    //     });

    //     return $this->success(new characterResource($character), 'Character purchased successfully!');

    // }

    // public function buyDice(Request $request, $id)
    // {
    //     $user = $request->user();
    //     $dice = Dice::findOrFail($id);

    //     if ($user->dices()->where('dice_id', $id)->exists()) {
    //         return $this->error('You already own this dice!', 400);
    //     }

    //     if ($user->gems < $dice->gems_cost) {
    //         return $this->error('Your balance is not enough!', 400);
    //     }

    //     DB::transaction(function () use ($user, $dice) {

    //         $user->decrement('gems', $dice->gems_cost);

    //         $user->dices()->attach($dice->id);
    //     });

    //     return $this->success(new DiceResource($dice), 'dice purchased successfully!');
    // }

    // public function buyNecklaces(Request $request, $id)
    // {
    //     $user = $request->user();
    //     $necklace = Necklace::findOrFail($id);

    //     if ($user->necklaces()->where('necklace_id', $id)->exists()) {
    //         return $this->error('You already own this necklace!', 400);
    //     }

    //     $currency = $necklace->gold_cost > 0 ? 'gold' : 'gems';
    //     $price = $necklace->gold_cost > 0 ? $necklace->gold_cost : $necklace->gems_cost;

    //     if ($price > $user->$currency) {
    //         return $this->error('Your balance is not enough!', 400);
    //     }

    //     DB::transaction(function () use ($user, $necklace, $currency, $price) {

    //         $user->decrement($currency, $price);

    //         $user->necklaces()->attach($necklace->id);
    //     });

    //     return $this->success(new NecklaceResource($necklace), 'Necklace purchased successfully!');
    // }

    // public function buyGold(Request $request, $id)
    // {
    //     $user = request()->user();
    //     $gold = Gold::findOrFail($id);

    //     if ($user->gold()->where('gold_id', $id)->exists()) {
    //         return $this->error('You already own this gold package!', 400);
    //     }

    //     if ($user->gems < $gold->gems_cost) {
    //         return $this->error('Your balance is not enough!', 400);
    //     }

    //     DB::transaction(function () use ($user, $gold) {
    //         $user->decrement('gems', $gold->gems_cost);
    //         $user->increment('gold', $gold->gold);
    //     });

    //     return $this->success(new GoldResource($gold), 'Gold purchased successfully!');
    // }






    public function getItemsByCategory(Request $request, $category)
    {
        $items = ShopItem::with('itemable')
            ->where('category', $category)
            ->where('is_active', true)
            ->paginate(15);

        return $this->success(['items'=>ShopItemResource::collection($items), "Items retrieved successfully"]);
    }

    
    public function buyItem(Request $request, $shopItemId)
    {
        $user = $request->user();
        $shopItem = ShopItem::with('itemable')->findOrFail($shopItemId);
        $item = $shopItem->itemable; 

        
        if ($this->isAlreadyOwned($user, $shopItem)) {
            return $this->error('You already own this item!', 400);
        }

             
        $finalPrice = $shopItem->price - ($shopItem->price * ($shopItem->discount_percentage / 100));

        if ($user->{$shopItem->currency_type} < $finalPrice) {
            return $this->error('Your balance is not enough!', 400);
        }

        DB::transaction(function () use ($user, $shopItem, $finalPrice, $item) {
              
            $user->decrement($shopItem->currency_type, $finalPrice);

            
            $this->attachItemToUser($user, $shopItem);
        });

        return $this->success(null, 'Purchase successful!');
    }

         
    private function isAlreadyOwned($user, $shopItem)
    {
        $relation = $shopItem->category; 
        
        if ($relation === 'gold') return false;

        return $user->$relation()
        ->where($relation . '.id', $shopItem->itemable_id)
        ->exists();
    }
    private function attachItemToUser($user, $shopItem)
    {
        $category = $shopItem->category;

        switch ($category) {
            case 'characters':
                $user->characters()->attach($shopItem->itemable_id, [
                    'current_level' => 1,
                    'is_selected' => false
                ]);
                break;
            case 'gold':
                $user->increment('gold', $shopItem->itemable->amount); 
                break;
            default:
                $user->$category()->attach($shopItem->itemable_id);
                break;
        }
    }
}
