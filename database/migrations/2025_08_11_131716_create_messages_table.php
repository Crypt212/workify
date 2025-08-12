<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->text('title');
        $table->text('body');
        $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
