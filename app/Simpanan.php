<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    // mendefinisikan nama table pada model
    protected $table = 'simpanan';

    // memberi izin untuk men insert value
    protected $guarded = [];

    // membuat relasi dengan table anggota
    public function anggota()
    {
        return $this->belongsTo('App\Anggota');
    }
}
