<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->date('tgl_lahir');
            $table->string('perusahaan');
            $table->string('nik', 20);
            $table->date('tgl_nik');
            $table->string('divisi');
            $table->string('bagian');
            $table->string('golongan');
            $table->integer('upah_pokok');
            $table->integer('tunjangan_jabatan');
            $table->integer('gaji');
            $table->integer('simpanan_sukarela');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anggota');
    }
}
