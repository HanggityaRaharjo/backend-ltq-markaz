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
        Schema::create('raport_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nilai_id')->nullable();
            $table->foreign('nilai_id')->references('id')->on('input_nilai_siswas')->onDelete('cascade');
            $table->string('rata-rata');
            $table->string('semester');
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
        Schema::dropIfExists('raport_siswas');
    }
};
