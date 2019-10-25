<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->string('kode',12)->unique();
            $table->string('nopol',10)->nullable();
            $table->enum('tipe_byr',['cash','credit','debit'])->nullable();
            $table->float('jumlah_byr',12,2)->nullable()->default(0);
            $table->enum('status',['proses','selesai','pending','batal'])->nullable();
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
        Schema::dropIfExists('transaksi');
    }
}
