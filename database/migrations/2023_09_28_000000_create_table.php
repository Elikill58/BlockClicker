<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('blockclicker_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('image');
            $table->unsignedInteger('required_click');
            $table->unsignedInteger('luck');
            $table->timestamps();
        });
        Schema::create('blockclicker_players', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('block_id');
            $table->unsignedInteger('amount');
            $table->timestamps();

            $table->foreign('block_id')->references('id')->on('blockclicker_blocks');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('blockclicker_blocks');
        Schema::dropIfExists('blockclicker_players');
    }
};