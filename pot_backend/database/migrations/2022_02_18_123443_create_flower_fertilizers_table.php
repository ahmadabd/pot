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
        Schema::create('flower_fertilizers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flower_id');
            $table->foreign('flower_id')->references('id')->on('flowers')->onDelete('cascade');
            $table->unsignedBigInteger('fertilizer_id');
            $table->foreign('fertilizer_id')->references('id')->on('fertilizers')->onDelete('cascade');
            $table->integer('period');
            $table->float('amount');
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
        Schema::dropIfExists('flower_fertilizers');
    }
};
