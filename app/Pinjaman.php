<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    // mendefinisikan nama table pada model
    protected $table = 'pinjaman';

    // memberi izin untuk men insert value
    protected $guarded = [];

    // membuat relasi dengan table jenis_pinjaman
    public function jenis_pinjaman()
    {
        return $this->belongsTo('App\JenisPinjaman');
    }

    // membuat relasi dengan table anggota
    public function anggota()
    {
        return $this->belongsTo('App\Anggota');
    }

    // membuat relasi dengan table angsuran
    public function angsuran()
    {
        return $this->hasMany('App\Angsuran');
    }
}
