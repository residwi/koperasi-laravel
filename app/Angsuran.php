<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    // mendefinisikan nama table pada model
    protected $table = 'angsuran';

    // memberi izin untuk men insert value
    protected $guarded = [];

    // membuat relasi dengan pinjaman
    public function pinjaman()
    {
        return $this->belongsTo('App\Pinjaman');
    }
}
