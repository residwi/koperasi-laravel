<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisPinjaman extends Model
{
    // mendefinisikan nama table pada model
    protected $table = 'jenis_pinjaman';

    // memberi izin untuk men insert value
    protected $fillable = [
        'nama', 'kelengkapan_dokumen'
    ];
}
