<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisPinjaman extends Model
{
    protected $table = 'jenis_pinjaman';

    protected $fillable = [
        'nama', 'kelengkapan_dokumen'
    ];
}
