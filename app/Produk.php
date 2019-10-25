<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    //
    protected $table='produk';
    protected $fillable=['nama','kategori_id','stok','satuan','barcode','harga','tipe_komisi','komisi'];

    public function kategori(){
        return $this->belongsTo(Kategori::class);
    }
    public function transaksi(){
        return $this->belongsToMany(Transaksi::class)->withPivot('jumlah');
    }
}
