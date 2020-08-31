<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    protected $table = 'angsuran';

    protected $guarded = [];

    public function pinjaman()
    {
        return $this->belongsTo('App\Pinjaman');
    }
}
