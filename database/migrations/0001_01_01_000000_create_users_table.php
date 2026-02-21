<?php

use App\Models\Country;
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

    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('username')->unique(); 
        $table->string('device_id')->unique(); 
        $table->string('email')->unique()->nullable();
        $table->string('password')->nullable(); 
  
        $table->integer('current_experience')->default(0); 
        $table->integer('level')->default(1); 

        $table->integer('wins')->default(0); 
        $table->integer('loses')->default(0); 

       
        $table->integer('gold')->default(0);
        $table->integer('gems')->default(0);
        
        $table->string('avatar')->default('default.png'); //remove db default and handle it in the model accessor (HINT: avatar_url)
        
        $table->integer('fav_character_id')->nullable();

        $table->string('provider_name')->nullable();
        $table->integer('provider_id')->nullable();
        $table->rememberToken(); //TODO: #minor| search on rememberToken usage 
        $table->timestamps();
    });


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
