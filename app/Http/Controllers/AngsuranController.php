<?php

namespace App\Http\Controllers;

use App\Angsuran;
use App\Pinjaman;
use Illuminate\Http\Request;

class AngsuranController extends Controller
{
    private const BUNGA_PINJAMAN = 0.35; // 35%

    // menampilkan page daftar angsuran
    public function index(Pinjaman $pinjaman)
    {
        // query untuk mendapatkan data paling terbaru 
        $angsuran = Angsuran::where('pinjaman_id', $pinjaman->id)->latest('created_at')->first();
        // (total_pinjaman * bunga) + total_pinjaman
        $pinjaman->jumlah_pengajuan += $pinjaman->jumlah_pengajuan * self::BUNGA_PINJAMAN;
        // untuk cek apakah sisa_pinjaman belum ada, jika kosong maka yang ditampilkan jumlah_pengajuannya
        $sisa_pinjaman = $angsuran->sisa_pinjaman ?? $pinjaman->jumlah_pengajuan;

        return view('adminlte.angsuran.index', compact(['pinjaman', 'sisa_pinjaman']));
    }

    // menampilkan page tambah angsuran
    public function create(Pinjaman $pinjaman)
    {
        // query untuk mendapatkan data paling terbaru
        $angsuran = Angsuran::where('pinjaman_id', $pinjaman->id)->latest('created_at')->first();
        // (total_pinjaman * bunga) + total_pinjaman
        $pinjaman->jumlah_pengajuan += $pinjaman->jumlah_pengajuan * self::BUNGA_PINJAMAN;
        // untuk cek apakah sisa_pinjaman belum ada, jika kosong maka yang ditampilkan jumlah_pengajuannya
        $sisa_pinjaman = $angsuran->sisa_pinjaman ?? $pinjaman->jumlah_pengajuan;

        return view('adminlte.angsuran.create', compact(['pinjaman', 'sisa_pinjaman']));
    }

    // proses untuk menyimpan
    public function store(Request $request, Pinjaman $pinjaman)
    {
        // dapetin semua data yg di input dari form
        $input = $request->all();

        $validator = \Validator::make($input, [
            'jumlah_angsuran' => 'required|numeric',
        ]);

        // jika validasi gagal maka muncul errror
        if ($validator->fails()) {
            return redirect()->route('pinjaman.angsuran.index', $pinjaman->id)
                ->withErrors($validator)
                ->withInput();
        }

        // query untuk mendapatkan angsuran yg terakhir dibayar
        $angsuranTerakhir = Angsuran::where('pinjaman_id', $pinjaman->id)->latest('created_at')->first();
        // (total_pinjaman * bunga) + total_pinjaman
        $pinjaman->jumlah_pengajuan += $pinjaman->jumlah_pengajuan * self::BUNGA_PINJAMAN;
        // untuk cek apakah sisa_pinjaman belum ada, jika kosong maka yang ditampilkan jumlah_pengajuannya
        $sisa_pinjaman = $angsuranTerakhir->sisa_pinjaman ?? $pinjaman->jumlah_pengajuan;

        $angsuran = new Angsuran($input);
        // sisa_pinjaman - jumlah_angsuran
        $angsuran->sisa_pinjaman = $sisa_pinjaman -  $input['jumlah_angsuran'];
        // menyimpan pinjaman_id
        $angsuran->pinjaman()->associate($pinjaman);
        $angsuran->save();

        return redirect()->route('pinjaman.angsuran.index', $pinjaman->id)->with('status', 'Angsuran berhasil dibayar');
    }

    public function edit(Angsuran $angsuran)
    {
        //
    }

    public function update(Request $request, Angsuran $angsuran)
    {
        //
    }

    public function destroy(Angsuran $angsuran)
    {
        //
    }
}
