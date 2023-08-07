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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cabang_lembaga_id')->nullable();
            $table->foreign('cabang_lembaga_id')->references('id')->on('cabang_lembagas')->onDelete('cascade');
            $table->unsignedBigInteger('program_day_id')->nullable();
            $table->foreign('program_day_id')->references('id')->on('program_days')->onDelete('cascade');
            $table->string('program_name');
            $table->string('description');
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
        Schema::dropIfExists('programs');
    }
};
