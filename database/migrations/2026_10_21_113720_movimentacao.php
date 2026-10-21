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
        /*Schema::create('movimentacao', function (Blueprint $table) {
            $table->id('id_movimentacao');
            $table->unsignedBigInteger('id_material');
            $table->foreign('id_material')->references('id_material')->on('material');
            $table->integer('quantidade');
            $table->string('tipo', 20);
            $table->timestamp('data_hora');
        });
    */}

    public function down(): void
    {
        //Schema::dropIfExists('movimentacao');
    }
};
