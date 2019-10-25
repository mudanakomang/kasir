<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->string('kode',10)->unique();
            $table->string('nama',150);
            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
            $table->integer('stok');
            $table->string('satuan');
            $table->string('barcode')->nullable();
            $table->float('harga',10,2);
            $table->enum('tipe_komisi',['fix','persen']);
            $table->float('komisi',10,2);
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
        Schema::dropIfExists('produk');
    }
}
