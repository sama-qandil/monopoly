<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gem;
class GemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gemsPack = Gem::create([
            'name' => 'Small Gems Pack',
            'amount' => 10,
            'money_cost' => 50,
            'icon' => 'small_gems_pack.png'
        ]);
    }
}
