<?php

namespace App\Http\Controllers;

use App\Simpanan;
use Illuminate\Http\Request;

class SimpananController extends Controller
{
    private const BUNGA_SIMPANAN = 0.10; // 10%
    private const SIMPANAN_POKOK = 100000;
    private const SIMPANAN_WAJIB = 50000;

    public function index()
    {
        $bunga = self::BUNGA_SIMPANAN * 100;
        
        if (auth()->user()->is_admin) {
            $simpanan = Simpanan::with('anggota.user')->get();
        } else {
            $user = auth()->user()->anggota_detail->id;
            $simpanan = Simpanan::where('anggota_id', $user)->with('anggota.user')->get();
        }

        $total_simpanan_sukarela = $simpanan->sum('total_simpanan_sukarela');

        $total_simpanan = (self::SIMPANAN_POKOK + self::SIMPANAN_WAJIB) * $simpanan->count() + $total_simpanan_sukarela;

        return view('adminlte.simpanan.index', compact([
            'simpanan',
            'bunga',
            'total_simpanan',
            'total_simpanan_sukarela'
        ]));
    }

    public function create()
    {
        return view('adminlte.simpanan.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = \Validator::make($input, [
            'simpanan_sukarela' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('simpanan.create')
                ->withErrors($validator)
                ->withInput();
        }

        $user = auth()->user()->anggota_detail;
        $bunga = self::BUNGA_SIMPANAN * $input['simpanan_sukarela'];

        $simpanan = new Simpanan([
            'simpanan_sukarela' => $input['simpanan_sukarela'],
            'bunga' => $bunga,
            'total_simpanan_sukarela' => $input['simpanan_sukarela'] + $bunga
        ]);

        $user->simpanan()->save($simpanan);

        return redirect()->route('simpanan.index')->with('status', 'Simpanan berhasil ditambahkan');
    }

    public function edit(Simpanan $simpanan)
    {
        return view('adminlte.simpanan.edit', compact('simpanan'));
    }

    public function update(Request $request, Simpanan $simpanan)
    {
        $input = $request->all();

        $validator = \Validator::make($input, [
            'simpanan_sukarela' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('simpanan.create')
                ->withErrors($validator)
                ->withInput();
        }
        $bunga = self::BUNGA_SIMPANAN * $input['simpanan_sukarela'];

        $simpanan->simpanan_sukarela       = $input['simpanan_sukarela'];
        $simpanan->bunga                   = $bunga;
        $simpanan->total_simpanan_sukarela = $input['simpanan_sukarela'] + $bunga;
        $simpanan->save();

        return redirect()->route('simpanan.index')->with('status', 'Simpanan berhasil diubah');
    }

    public function destroy(Simpanan $simpanan)
    {
        $simpanan->delete();

        return response()->json(['success => true']);
    }
}
