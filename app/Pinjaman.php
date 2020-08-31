<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    protected $table = 'pinjaman';

    protected $guarded = [];

    public function jenis_pinjaman()
    {
        return $this->belongsTo('App\JenisPinjaman');
    }

    public function anggota()
    {
        return $this->belongsTo('App\Anggota');
    }

    public function angsuran()
    {
        return $this->hasMany('App\Angsuran');
    }
}
