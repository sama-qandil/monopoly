<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Gold;
use App\Enums\CurrencyType;


use App\Models\ShopItem;

class GoldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $goldPackage1 = Gold::create([
        'amount' => 1000,
        
        'icon' => 'small_gold.png'
    ]);

    $goldPackage1->shopItem()->create([
        'category'=>'gold',
        'itemable_type'=>Gold::class,
        'itemable_id'=>$goldPackage1->id,
        'price'=>200,
        'currency_type'=>CurrencyType::GEMS,
        'is_active'=>true,
    ]);
    }
}
