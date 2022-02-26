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
            $table->foreignIdFor('flowers')->constrained()->onDelete('cascade');
            $table->foreignIdFor('fertilizers')->constrained()->onDelete('cascade');
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
