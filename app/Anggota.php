<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    // mendefinisikan nama table pada model
    protected $table = 'anggota';

    // memberi izin untuk men insert value
    protected $guarded = [];

    // mengubah hasil query dari string ke tipe date
    protected $casts = [
        'tgl_lahir' => 'date',
        'tgl_nik' => 'date',
    ];

    // membuat relasi dengan table simpanan
    public function simpanan()
    {
        return $this->hasMany('App\Simpanan');
    }

    // membuat relasi dengan table pinjaman
    public function pinjaman()
    {
        return $this->hasMany('App\Pinjaman');
    }

    // membuat relasi dengan table user
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
