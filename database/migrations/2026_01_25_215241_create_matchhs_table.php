<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Matchh;
use App\Models\User;
use App\Models\Character;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matchhs', function (Blueprint $table) {
            $table->id();
            $table->string('map_name');
            $table->integer('winner_id')->nullable();
            $table->timestamps();
        });




        Schema::create('matchh_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Matchh::class);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Character::class);

            $table->integer('gold_gained');
            $table->integer('gems_gained');
            $table->integer('rank');
            $table->integer('wins');
            $table->integer('loss');
            $table->integer('experience_gained');

            


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matchhs');
    }
};
