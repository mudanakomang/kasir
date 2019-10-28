<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    //
    protected $table ='transaksi';
    protected $fillable=['kode','nopol','tipe_byr','total','jumlah_byr','status','user_id','print','finishtime'];

    public function produk(){
        return $this->belongsToMany(Produk::class)->withPivot(['jumlah','diskon']);
    }
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
    public function guide(){
        return $this->belongsTo(Guide::class);
    }
}
