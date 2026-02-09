<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::create('characters', function (Blueprint $table) {
         $table->id();
            $table->string('name');
            $table->string('gender');
            $table->string('category');
            $table->string('ability');
            $table->integer('max_level')->default(1);
            $table->string('avatar');
            $table->integer('gold_price');
            $table->integer('gems_price');
    }
    );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
