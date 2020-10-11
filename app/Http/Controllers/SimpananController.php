<?php

namespace App\Http\Controllers;

use App\Anggota;
use App\Simpanan;
use Illuminate\Http\Request;

class SimpananController extends Controller
{
    private const BUNGA_SIMPANAN = 0.10; // 10%
    private const SIMPANAN_POKOK = 100000;
    private const SIMPANAN_WAJIB = 50000;

    // menampilkan page daftar simpanan
    public function index()
    {
        $bunga = self::BUNGA_SIMPANAN * 100;

        // cek apakah user admin
        if (auth()->user()->is_admin) {
            // query untuk melihat semua data simpanan
            $simpanan = Simpanan::with('anggota.user')->get();
        } else {
            // query untuk melihat semua data simpanan anggota yg login
            $user = auth()->user()->anggota_detail->id;
            $simpanan = Simpanan::where('anggota_id', $user)->with('anggota.user')->get();
        }

        // hitung total simpanan sukarela
        $total_simpanan_sukarela = $simpanan->sum('total_simpanan_sukarela');

        // perhitungan total simpanan
        $total_simpanan = (self::SIMPANAN_POKOK + self::SIMPANAN_WAJIB) * $simpanan->count() + $total_simpanan_sukarela;

        return view('adminlte.simpanan.index', compact([
            'simpanan',
            'bunga',
            'total_simpanan',
            'total_simpanan_sukarela'
        ]));
    }


    // menampilkan page tambah simpanan
    public function create()
    {
        $anggota = Anggota::all();
        return view('adminlte.simpanan.create', compact('anggota'));
    }

    // proses untuk menyimpan
    public function store(Request $request)
    {
        // dapetin semua data yg di input dari form
        $input = $request->all();

        $validator = \Validator::make($input, [
            'simpanan_sukarela' => 'required|numeric',
        ]);

        // jika validasi gagal maka muncul errror
        if ($validator->fails()) {
            return redirect()->route('simpanan.create')
                ->withErrors($validator)
                ->withInput();
        }

        // mendapatkan data diri anggota yg sedang login
        $user = auth()->user()->anggota_detail;
        $bunga = self::BUNGA_SIMPANAN * $input['simpanan_sukarela'];

        if (auth()->user()->is_admin) {
            $user = Anggota::find($request->anggota);
        }

        // save data simpanan user
        $simpanan = new Simpanan([
            'simpanan_sukarela' => $input['simpanan_sukarela'],
            'bunga' => $bunga,
            'total_simpanan_sukarela' => $input['simpanan_sukarela'] + $bunga
        ]);
        $user->simpanan()->save($simpanan);

        return redirect()->route('simpanan.index')->with('status', 'Simpanan berhasil ditambahkan');
    }

    // menampilkan page edit simpanan
    public function edit(Simpanan $simpanan)
    {
        $anggota = Anggota::all();
        return view('adminlte.simpanan.edit', compact('simpanan', 'anggota'));
    }

    // proses untuk mengupdate dari edit
    public function update(Request $request, Simpanan $simpanan)
    {
        // dapetin semua data yg di input dari form
        $input = $request->all();

        $validator = \Validator::make($input, [
            'simpanan_sukarela' => 'required|numeric',
        ]);

        // jika validasi gagal maka muncul errror
        if ($validator->fails()) {
            return redirect()->route('simpanan.create')
                ->withErrors($validator)
                ->withInput();
        }

        // proses update
        $bunga = self::BUNGA_SIMPANAN * $input['simpanan_sukarela'];

        $simpanan->simpanan_sukarela       = $input['simpanan_sukarela'];
        $simpanan->bunga                   = $bunga;
        $simpanan->total_simpanan_sukarela = $input['simpanan_sukarela'] + $bunga;
        $simpanan->save();

        return redirect()->route('simpanan.index')->with('status', 'Simpanan berhasil diubah');
    }

    // proses menghapus simpanan
    public function destroy(Simpanan $simpanan)
    {
        $simpanan->delete();

        return response()->json(['success => true']);
    }
}
