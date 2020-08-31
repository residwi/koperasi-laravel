<?php

namespace App\Http\Controllers;

use App\JenisPinjaman;
use App\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PinjamanController extends Controller
{
    private const BUNGA_PINJAMAN = 0.35; // 35%

    public function index()
    {
        if (auth()->user()->is_admin) {
            $pinjaman = Pinjaman::with('anggota.user')->get();
        } else {
            $user = auth()->user()->anggota_detail->id;
            $pinjaman = Pinjaman::where('anggota_id', $user)->with(['anggota.user', 'jenis_pinjaman'])->get();
        }

        return view('adminlte.pinjaman.index', compact(['pinjaman']));
    }

    public function create()
    {
        $anggota = auth()->user()->anggota_detail;
        $masa_kerja = date_diff($anggota->tgl_nik, now()); // dari selisih tanggal_nik sampai sekarang
        $jenis_pinjaman = JenisPinjaman::all();

        return view('adminlte.pinjaman.create', compact(['anggota', 'masa_kerja', 'jenis_pinjaman']));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = \Validator::make($input, [
            'keperluan'                => 'required|string',
            'keterangan'               => 'string|nullable',
            'jenis_pinjaman'           => 'required|exists:jenis_pinjaman,id',
            'jumlah_pengajuan'         => 'required|numeric',
            'angsuran_yang_disanggupi' => 'required|numeric',
            'dokumen'                  => 'required|mimes:jpg,jpeg,bmp,png,pdf'
        ]);

        if ($validator->fails()) {
            return redirect()->route('pinjaman.create')
                ->withErrors($validator)
                ->withInput();
        }

        $path = Storage::putFile(
            'public/dokumen',
            $request->file('dokumen'),
        );

        $user = auth()->user()->anggota_detail;
        $jenis_pinjaman = JenisPinjaman::find($input['jenis_pinjaman']);

        $pinjaman = new Pinjaman([
            'keperluan'                => $input['keperluan'],
            'keterangan'               => $input['keterangan'],
            'jumlah_pengajuan'         => $input['jumlah_pengajuan'],
            'angsuran_yang_disanggupi' => $input['angsuran_yang_disanggupi'],
            'dokumen'                  => $path,
        ]);

        $pinjaman->anggota()->associate($user);
        $pinjaman->jenis_pinjaman()->associate($jenis_pinjaman);
        $pinjaman->save();

        return redirect()->route('pinjaman.index')->with('status', 'Pinjaman berhasil diajukan');
    }

    public function show(Pinjaman $pinjaman)
    {
        $jenis_pinjaman = JenisPinjaman::all();
        $masa_kerja = date_diff($pinjaman->anggota->tgl_nik, now()); // dari selisih tanggal_nik sampai sekarang

        return view('adminlte.pinjaman.show', compact(['pinjaman', 'jenis_pinjaman', 'masa_kerja']));
    }

    public function edit(Pinjaman $pinjaman)
    {
        $jenis_pinjaman = JenisPinjaman::all();
        $masa_kerja = date_diff($pinjaman->anggota->tgl_nik, now()); // dari selisih tanggal_nik sampai sekarang

        return view('adminlte.pinjaman.edit', compact(['pinjaman', 'jenis_pinjaman', 'masa_kerja']));
    }

    public function update(Request $request, Pinjaman $pinjaman)
    {
        $input = $request->all();

        $validator = \Validator::make($input, [
            'keperluan'                => 'required|string',
            'keterangan'               => 'string|nullable',
            'jenis_pinjaman'           => 'required|exists:jenis_pinjaman,id',
            'jumlah_pengajuan'         => 'required|numeric',
            'angsuran_yang_disanggupi' => 'required|numeric',
            'dokumen'                  => 'mimes:jpg,jpeg,bmp,png,pdf|nullable'
        ]);

        if ($validator->fails()) {
            return redirect()->route('pinjaman.edit')
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->file('dokumen')) {
            $path = Storage::putFile('public/dokumen', $request->file('dokumen'));

            $pinjaman->dokumen = $path;
        }

        $user = auth()->user()->anggota_detail;
        $jenis_pinjaman = JenisPinjaman::find($input['jenis_pinjaman']);

        $pinjaman->keperluan = $input['keperluan'];
        $pinjaman->keterangan = $input['keterangan'];
        $pinjaman->jumlah_pengajuan = $input['jumlah_pengajuan'];
        $pinjaman->angsuran_yang_disanggupi = $input['angsuran_yang_disanggupi'];
        $pinjaman->anggota()->associate($user);
        $pinjaman->jenis_pinjaman()->associate($jenis_pinjaman);
        $pinjaman->save();

        return redirect()->route('pinjaman.index')->with('status', 'Pinjaman berhasil diubah');
    }

    public function destroy(Pinjaman $pinjaman)
    {
        // $pinjaman->delete();

        // return response()->json(['success => true']);
    }

    public function status(Request $request, Pinjaman $pinjaman)
    {
        $data = json_decode($request->getContent(), true);

        if ($pinjaman->status != 'proses') {
            return response()->json(['success => false'], 404);
        }

        $pinjaman->status = ($data['status'] == 1 ? 'diterima' : 'ditolak');
        $pinjaman->save();

        return response()->json(['success => true']);
    }
}
