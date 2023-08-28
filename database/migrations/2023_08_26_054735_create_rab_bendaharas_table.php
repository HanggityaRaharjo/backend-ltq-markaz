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
        Schema::create('rab_bendaharas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kebutuhan')->nullable();
            $table->bigInteger('qty')->nullable();
            $table->bigInteger('biaya')->nullable();
            $table->bigInteger('jumlah')->nullable();
            $table->bigInteger('total')->nullable();
            $table->date('tanggal')->nullable();
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
        Schema::dropIfExists('rab_bendaharas');
    }
};
