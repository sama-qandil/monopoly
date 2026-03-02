<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Gold;

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
        'gems_cost' => 10,
        'icon' => 'small_gold.png'
    ]);

    ShopItem::create([
        'category' => 'gold',
        'price' => 10,    
        'currency_type' => \App\Enums\CurrencyType::GEMS,   
        'itemable_id' => $goldPackage1->id,
        'itemable_type' => Gold::class,
        'is_active' => true
    ]);
    }
}
