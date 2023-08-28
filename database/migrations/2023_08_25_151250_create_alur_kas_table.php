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
        Schema::create('alur_kas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_transaksi')->nullable();
            $table->unsignedBigInteger('ketegori_transaksi')->nullable();
            $table->foreign('ketegori_transaksi')->references('id')->on('kategori_transaksis')->onDelete('cascade');
            $table->date('tanggal')->nullable();
            $table->string('keterangan')->nullable();
            $table->bigInteger('pemasukan')->nullable();
            $table->bigInteger('pengeluaran')->nullable();
            $table->bigInteger('nominal')->nullable();
            $table->bigInteger('jumlah')->nullable();
            $table->bigInteger('total')->nullable();
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
        Schema::dropIfExists('alur_kas');
    }
};
