<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    //
    public function transaksi(){
        return $this->belongsTo(Transaksi::class);
    }
}
