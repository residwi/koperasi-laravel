<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePinjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggota');
            $table->text('keperluan');
            $table->integer('jumlah_pengajuan');
            $table->integer('angsuran_yang_disanggupi');
            $table->foreignId('jenis_pinjaman_id')->constrained('jenis_pinjaman');
            $table->text('keterangan')->nullable();
            $table->string('dokumen')->nullable();
            $table->enum('status', ['ditolak', 'diterima', 'proses'])->default('proses');
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
        Schema::dropIfExists('pinjaman');
    }
}
