<?php

use App\JenisPinjaman;
use Illuminate\Database\Seeder;

class JenisPinjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisPinjaman::insert([
            [
                'nama' => 'Biaya Sekolah',
                'kelengkapan_dokumen' => 'Bukti masuk sekolah / tagihan / pembayaran dari pihak Sekolah / PT.'
            ],
            [
                'nama' => 'Kontrak Rumah',
                'kelengkapan_dokumen' => 'Perjanjian Kontrak Rumah atau kwitansi pembayaran.'
            ],
            [
                'nama' => 'Uang Muka KPR',
                'kelengkapan_dokumen' => 'Perjanjian Akad Kredit.'
            ],
            [
                'nama' => 'Kredit Motor',
                'kelengkapan_dokumen' => 'Sesuai surat ketentuan kredit sepeda motor.'
            ],
            [
                'nama' => 'Renovasi Rumah',
                'kelengkapan_dokumen' => 'Copy SPPT PBB, Akta Rumah dan Rencana Anggaran Biaya.'
            ],
            [
                'nama' => 'Pinjaman Lainnya',
                'kelengkapan_dokumen' => 'Bukti yang relevan.'
            ],
        ]);
    }
}
