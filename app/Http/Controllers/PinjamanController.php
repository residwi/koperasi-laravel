<?php

namespace App\Http\Controllers;

use App\Anggota;
use App\Angsuran;
use App\JenisPinjaman;
use App\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PinjamanController extends Controller
{
    private const BUNGA_PINJAMAN = 0.35; // 35%

    // menampilkan page daftar pinjaman
    public function index()
    {
        // cek apakah user admin
        if (auth()->user()->is_admin) {
            // query untuk melihat semua data pinjaman
            $pinjaman = Pinjaman::with('anggota.user')->get();
        } else {
            // query untuk melihat semua data pinjaman anggota yg login
            $user = auth()->user()->anggota_detail->id;
            $pinjaman = Pinjaman::where('anggota_id', $user)->with(['anggota.user', 'jenis_pinjaman'])->get();
        }

        return view('adminlte.pinjaman.index', compact(['pinjaman']));
    }

    // menampilkan page ajukan peminjaman
    public function create()
    {
        // mendaptkan master data jenis pinjaman
        $jenis_pinjaman = JenisPinjaman::all();

        if (auth()->user()->is_admin) {
            $anggota = Anggota::with('user')->get();
            return view('adminlte.pinjaman.admin-create', compact('anggota', 'jenis_pinjaman'));
        }

        $anggota = auth()->user()->anggota_detail;
        $pinjaman = $anggota->pinjaman->last();
        if ($pinjaman) {
            // query untuk mendapatkan data paling terbaru 
            $angsuran = Angsuran::where('pinjaman_id', $pinjaman->id)->latest('created_at')->first();
            // (total_pinjaman * bunga) + total_pinjaman
            $pinjaman->jumlah_pengajuan += $pinjaman->jumlah_pengajuan * self::BUNGA_PINJAMAN;
            // untuk cek apakah sisa_pinjaman belum ada, jika kosong maka yang ditampilkan jumlah_pengajuannya
            $sisa_pinjaman = $angsuran->sisa_pinjaman ?? $pinjaman->jumlah_pengajuan;

            // jika masih ada angsuran yg belum lunas
            if ($sisa_pinjaman != 0) {
                return redirect()->route('pinjaman.index')->with('pengajuan_gagal', 'Maaf Anda Masih Punya Angsuran');
            }
        }

        // mendapatkan data diri anggota yg sedang login
        $masa_kerja = date_diff($anggota->tgl_nik, now()); // dari selisih tanggal_nik sampai sekarang

        return view('adminlte.pinjaman.create', compact(['anggota', 'masa_kerja', 'jenis_pinjaman']));
    }

    // proses untuk menyimpan
    public function store(Request $request)
    {
        // dapetin semua data yg di input dari form
        $input = $request->all();

        $validator = \Validator::make($input, [
            'keperluan'                => 'required|string',
            'keterangan'               => 'string|nullable',
            'jenis_pinjaman'           => 'required|exists:jenis_pinjaman,id',
            'jumlah_pengajuan'         => 'required|numeric',
            'angsuran_yang_disanggupi' => 'required|numeric',
            'dokumen'                  => 'required|mimes:jpg,jpeg,bmp,png,pdf'
        ]);

        // jika validasi gagal maka muncul errror
        if ($validator->fails()) {
            return redirect()->route('pinjaman.create')
                ->withErrors($validator)
                ->withInput();
        }

        // upload dokumen ke folder public/dokumen
        $path = Storage::putFile(
            'public/dokumen',
            $request->file('dokumen')
        );

        // mendapatkan data diri anggota yg sedang login
        $user = auth()->user()->anggota_detail;

        if (auth()->user()->is_admin) {
            $user = $input['anggota'];
        }

        // proses menyimpan pinjaman
        $jenis_pinjaman = JenisPinjaman::find($input['jenis_pinjaman']);

        $pinjaman = new Pinjaman([
            'keperluan'                => $input['keperluan'],
            'keterangan'               => $input['keterangan'],
            'jumlah_pengajuan'         => $input['jumlah_pengajuan'],
            'angsuran_yang_disanggupi' => $input['angsuran_yang_disanggupi'],
            'dokumen'                  => $path,
        ]);

        // menyimpan anggota_id berdasarkan user yang sedang login
        $pinjaman->anggota()->associate($user);
        // menyimpan jenis_pinjaman_id berdasarkan pilihan user
        $pinjaman->jenis_pinjaman()->associate($jenis_pinjaman);
        $pinjaman->save();

        return redirect()->route('pinjaman.index')->with('status', 'Pinjaman berhasil diajukan');
    }

    // menampilkan page detail dari data pinjaman
    public function show(Pinjaman $pinjaman)
    {
        $jenis_pinjaman = JenisPinjaman::all();
        $masa_kerja = date_diff($pinjaman->anggota->tgl_nik, now()); // dari selisih tanggal_nik sampai sekarang

        return view('adminlte.pinjaman.show', compact(['pinjaman', 'jenis_pinjaman', 'masa_kerja']));
    }

    // menampilkan page edit pinjaman
    public function edit(Pinjaman $pinjaman)
    {
        // query untuk mendapatkan semua jenis_pinjaman
        $jenis_pinjaman = JenisPinjaman::all();
        $masa_kerja = date_diff($pinjaman->anggota->tgl_nik, now()); // dari selisih tanggal_nik sampai sekarang

        return view('adminlte.pinjaman.edit', compact(['pinjaman', 'jenis_pinjaman', 'masa_kerja']));
    }

    // proses untuk mengupdate dari edit
    public function update(Request $request, Pinjaman $pinjaman)
    {
        // dapetin semua data yg di input dari form
        $input = $request->all();

        $validator = \Validator::make($input, [
            'keperluan'                => 'required|string',
            'keterangan'               => 'string|nullable',
            'jenis_pinjaman'           => 'required|exists:jenis_pinjaman,id',
            'jumlah_pengajuan'         => 'required|numeric',
            'angsuran_yang_disanggupi' => 'required|numeric',
            'dokumen'                  => 'mimes:jpg,jpeg,bmp,png,pdf|nullable'
        ]);

        // jika validasi gagal maka muncul errror
        if ($validator->fails()) {
            return redirect()->route('pinjaman.edit')
                ->withErrors($validator)
                ->withInput();
        }

        // jika ada file yg ingin diupload
        if ($request->file('dokumen')) {
            // proses upload
            $path = Storage::putFile('public/dokumen', $request->file('dokumen'));

            $pinjaman->dokumen = $path;
        }

        // mendapatkan data diri anggota yg sedang login
        $user = auth()->user()->anggota_detail;

        // proses menyimpan pinjaman
        $jenis_pinjaman = JenisPinjaman::find($input['jenis_pinjaman']);

        $pinjaman->keperluan = $input['keperluan'];
        $pinjaman->keterangan = $input['keterangan'];
        $pinjaman->jumlah_pengajuan = $input['jumlah_pengajuan'];
        $pinjaman->angsuran_yang_disanggupi = $input['angsuran_yang_disanggupi'];

        // menyimpan anggota_id berdasarkan user yang sedang login
        $pinjaman->anggota()->associate($user);

        // menyimpan jenis_pinjaman_id berdasarkan pilihan user
        $pinjaman->jenis_pinjaman()->associate($jenis_pinjaman);
        $pinjaman->save();

        return redirect()->route('pinjaman.index')->with('status', 'Pinjaman berhasil diubah');
    }

    public function destroy(Pinjaman $pinjaman)
    {
        // $pinjaman->delete();

        // return response()->json(['success => true']);
    }

    // proses untuk mengubah status pinjaman
    public function status(Request $request, Pinjaman $pinjaman)
    {
        // menerima hasil request dari page
        $data = json_decode($request->getContent(), true);

        // jika status selain proses maka error
        if ($pinjaman->status != 'proses') {
            return response()->json(['success => false'], 404);
        }

        // proses simpan status
        $pinjaman->status = ($data['status'] == 1 ? 'diterima' : 'ditolak');
        $pinjaman->save();

        return response()->json(['success => true']);
    }
}
