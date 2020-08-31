<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Anggota;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('adminlte.home');
    }

    public function formAnggota()
    {
        if (auth()->user()->anggota_detail || auth()->user()->is_admin) {
            return redirect('home');
        }

        return view('adminlte.anggota.daftar', ['nama' => auth()->user()->name]);
    }

    public function complete(Request $request)
    {
        if (auth()->user()->anggota_detail) {
            return redirect('home');
        }

        $input = $request->all();

        $validator = \Validator::make($input, [
            'tgl_lahir'         => 'required|date_format:d/m/Y',
            'perusahaan'        => 'required|string',
            'nik'               => 'required|string',
            'tgl_nik'           => 'required|date_format:d/m/Y',
            'divisi'            => 'required|string',
            'bagian'            => 'required|string',
            'golongan'          => 'required|string',
            'upah_pokok'        => 'required|numeric',
            'tunjangan_jabatan' => 'required|numeric',
            'gaji'              => 'required|numeric',
            'simpanan_sukarela' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect('daftar-anggota')
                ->withErrors($validator)
                ->withInput();
        }

        $input['user_id'] = auth()->id();
        $input['tgl_lahir'] = Carbon::createFromFormat('d/m/Y', $input['tgl_lahir'])->format('Y-m-d');
        $input['tgl_nik'] = Carbon::createFromFormat('d/m/Y', $input['tgl_nik'])->format('Y-m-d');

        Anggota::create($input);

        return redirect()->route('home')->with('status', 'Data diri berhasil ditambahkan');
    }
}
