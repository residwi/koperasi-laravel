<?php

namespace App\Http\Controllers;

use App\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    // menampilkan page daftar anggota
    public function index()
    {
        // query mendapatkan list anggota
        $anggota = Anggota::with('user')->get();

        return view('adminlte.anggota.index', compact('anggota'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Anggota $anggota)
    {
        //
    }

    public function edit(Anggota $anggota)
    {
        //
    }

    public function update(Request $request, Anggota $anggota)
    {
        //
    }

    public function destroy(Anggota $anggota)
    {
        //
    }
}
