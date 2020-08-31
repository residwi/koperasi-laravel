<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';

    protected $guarded = [];

    protected $casts = [
        'tgl_lahir' => 'date',
        'tgl_nik' => 'date',
    ];

    public function simpanan()
    {
        return $this->hasMany('App\Simpanan');
    }

    public function pinjaman()
    {
        return $this->hasMany('App\Pinjaman');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
