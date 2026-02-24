<?php

// app/Http/Controllers/Api/StoreController.php

namespace App\Http\Controllers;

use App\Http\Resources\characterResource;
use App\Http\Resources\DiceResource;
use App\Http\Resources\GoldResource;
use App\Http\Resources\NecklaceResource;
use App\Models\Character;
use App\Models\Dice;
use App\Models\Gold;
use App\Models\Jewelry;
use App\Models\Necklace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function getitemByCategory(Request $request, $category)
    {
        // TODO: use pagination
        $data = match ($category) {
            'characters' => Character::all(),
            'dices' => Dice::all(),
            'necklaces' => Necklace::all(),
            'gold' => Gold::all(),
            'jewelries' => Jewelry::all(),
            default => null,

        };

        // TODO: use resource
        return $this->success($data, "Items of category $category retrieved successfully");
    }

    public function getitemDetails(Request $request, $category, $id)
    {
        $data = match ($category) {
            'characters' => Character::query(),
            'dices' => Dice::query(),
            'necklaces' => Necklace::query(),
            'gold' => Gold::query(),
            'jewelries' => Jewelry::query(),
            default => null,

        };
        $item = $data->findOrFail($id);

        return $this->success($item, 'Item details retrieved successfully');
    }

    public function buyCharacter(Request $request, $id)
    {
        $user = $request->user();
        $character = Character::findOrFail($id);

        if ($user->characters()->where('character_id', $id)->exists()) {
            return $this->error('You already own this character!', 400);
        }

        $currency = $character->gold_price > 0 ? 'gold' : 'gems';
        $price = $character->gold_price > 0 ? $character->gold_price : $character->gems_price;

        if ($price > $user->$currency) {
            return $this->error('Your balance is not enough!', 400);
        }

        DB::transaction(function () use ($user, $character, $currency, $price) {

            $user->decrement($currency, $price);

            $user->characters()->attach($character->id, [
                'current_level' => 1,
                'current_experience' => 0,
                'is_selected' => false,
            ]);
        });

        return $this->success(new characterResource($character), 'Character purchased successfully!');

    }

    public function buyDice(Request $request, $id)
    {
        $user = $request->user();
        $dice = Dice::findOrFail($id);

        if ($user->dices()->where('dice_id', $id)->exists()) {
            return $this->error('You already own this dice!', 400);
        }

        if ($user->gems < $dice->gems_cost) {
            return $this->error('Your balance is not enough!', 400);
        }

        DB::transaction(function () use ($user, $dice) {

            $user->decrement('gems', $dice->gems_cost);

            $user->dices()->attach($dice->id);
        });

        return $this->success(new DiceResource($dice), 'dice purchased successfully!');
    }

    public function buyNecklaces(Request $request, $id)
    {
        $user = $request->user();
        $necklace = Necklace::findOrFail($id);

        if ($user->necklaces()->where('necklace_id', $id)->exists()) {
            return $this->error('You already own this necklace!', 400);
        }

        $currency = $necklace->gold_cost > 0 ? 'gold' : 'gems';
        $price = $necklace->gold_cost > 0 ? $necklace->gold_cost : $necklace->gems_cost;

        if ($price > $user->$currency) {
            return $this->error('Your balance is not enough!', 400);
        }

        DB::transaction(function () use ($user, $necklace, $currency, $price) {

            $user->decrement($currency, $price);

            $user->necklaces()->attach($necklace->id);
        });

        return $this->success(new NecklaceResource($necklace), 'Necklace purchased successfully!');
    }

    public function buyGold(Request $request, $id)
    {
        $user = request()->user();
        $gold = Gold::findOrFail($id);

        if ($user->gold()->where('gold_id', $id)->exists()) {
            return $this->error('You already own this gold package!', 400);
        }

        if ($user->gems < $gold->gems_cost) {
            return $this->error('Your balance is not enough!', 400);
        }

        DB::transaction(function () use ($user, $gold) {
            $user->decrement('gems', $gold->gems_cost);
            $user->increment('gold', $gold->gold);
        });

        return $this->success(new GoldResource($gold), 'Gold purchased successfully!');
    }
}
