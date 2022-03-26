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
        Schema::create('fertilizer_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flower_id');
            $table->foreign('flower_id')->references('id')->on('flowers')->onDelete('cascade');
            $table->unsignedBigInteger('flower_fertilizer_id');
            $table->foreign('flower_fertilizer_id')->references('id')->on('flower_fertilizers')->onDelete('cascade');
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
        Schema::dropIfExists('fertilizer_reports');
    }
};
