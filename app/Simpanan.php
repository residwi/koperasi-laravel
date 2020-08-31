<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    protected $table = 'simpanan';

    protected $guarded = [];

    public function anggota()
    {
        return $this->belongsTo('App\Anggota');
    }
}
