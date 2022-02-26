<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_flowers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor('users')->constrained()->onDelete('cascade');
            $table->foreignIdFor('flowers')->constrained()->onDelete('cascade');
            $table->unsignedSmallInteger('role');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_flowers');
    }
};
