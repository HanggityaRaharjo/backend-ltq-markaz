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
        Schema::create('pembayaran_barangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('konsumen_id')->nullable();
            $table->foreign('konsumen_id')->references('id')->on('konsumens')->onDelete('cascade');
            $table->date('tanggal_pembayaran');
            $table->decimal('jumlah_pembayaran');
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
        Schema::dropIfExists('pembayaran_barangs');
    }
};
