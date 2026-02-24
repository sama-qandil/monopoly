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
        Schema::create('friend_invites', function (Blueprint $table) {

            $table->id();
            $table->foreignIdFor(App\Models\User::class, 'sender_id');
            $table->foreignIdFor(App\Models\User::class, 'receiver_id');

            $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending');

            $table->timestamp('delivered_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friend_invites');
    }
};
