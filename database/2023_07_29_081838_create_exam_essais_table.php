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
        Schema::create('exam_essais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_level_id')->nullable();
            $table->foreign('user_level_id')->references('id')->on('user_levels')->onDelete('cascade');
            $table->string('jenis_exam');
            $table->string('question');
            $table->string('true_answer');
            $table->string('code');
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
        Schema::dropIfExists('exam_essais');
    }
};
