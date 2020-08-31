<?php

namespace App\Http\Controllers;

use App\Angsuran;
use App\Pinjaman;
use Illuminate\Http\Request;

class AngsuranController extends Controller
{
    private const BUNGA_PINJAMAN = 0.35; // 35%

    public function index(Pinjaman $pinjaman)
    {
        $angsuran = Angsuran::where('pinjaman_id', $pinjaman->id)->latest('created_at')->first();
        $pinjaman->jumlah_pengajuan += $pinjaman->jumlah_pengajuan * self::BUNGA_PINJAMAN; // total_pinjaman * bunga
        $sisa_pinjaman = $angsuran->sisa_pinjaman ?? $pinjaman->jumlah_pengajuan;
        
        return view('adminlte.angsuran.index', compact(['pinjaman', 'sisa_pinjaman']));
    }

    public function create(Pinjaman $pinjaman)
    {
        $angsuran = Angsuran::where('pinjaman_id', $pinjaman->id)->latest('created_at')->first();
        $pinjaman->jumlah_pengajuan += $pinjaman->jumlah_pengajuan * self::BUNGA_PINJAMAN; // total_pinjaman * bunga
        $sisa_pinjaman = $angsuran->sisa_pinjaman ?? $pinjaman->jumlah_pengajuan;
        
        return view('adminlte.angsuran.create', compact(['pinjaman', 'sisa_pinjaman']));
    }

    public function store(Request $request, Pinjaman $pinjaman)
    {
        $input = $request->all();

        $validator = \Validator::make($input, [
            'jumlah_angsuran' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('pinjaman.angsuran.index', $pinjaman->id)
                ->withErrors($validator)
                ->withInput();
        }

        $angsuranTerakhir = Angsuran::where('pinjaman_id', $pinjaman->id)->latest('created_at')->first();
        $pinjaman->jumlah_pengajuan += $pinjaman->jumlah_pengajuan * self::BUNGA_PINJAMAN; // total_pinjaman * bunga
        $sisa_pinjaman = $angsuranTerakhir->sisa_pinjaman ?? $pinjaman->jumlah_pengajuan;

        $angsuran = new Angsuran($input);
        $angsuran->sisa_pinjaman = $sisa_pinjaman -  $input['jumlah_angsuran'];
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
