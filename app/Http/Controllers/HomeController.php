<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Anggota;
use App\Pinjaman;
use App\Simpanan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    private const SIMPANAN_POKOK = 100000;
    private const SIMPANAN_WAJIB = 50000;

    // menampilkan page dashboard
    public function index()
    {
        return view('adminlte.home');
    }

    // menampilkan form anggota ketika  baru daftar
    public function formAnggota()
    {
        // jika user baru dan bukan admin
        if (auth()->user()->anggota_detail && !auth()->user()->is_admin) {
            return redirect('home');
        }

        return view('adminlte.anggota.daftar');
    }

    // proses menyimpan data anggota baru
    public function complete(Request $request)
    {
        if (auth()->user()->anggota_detail) {
            return redirect('home');
        }

        // dapetin semua data yg di input dari form
        $input = $request->except(['nama', 'username', 'password', 'password_confirmation']);

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
            'dokumen'           => 'required|mimes:jpg,jpeg,bmp,png,pdf'
        ]);

        // jika validasi gagal maka muncul errror
        if ($validator->fails()) {
            return redirect('daftar-anggota')
                ->withErrors($validator)
                ->withInput();
        }

        // upload dokumen ke folder public/dokumen
        $path = Storage::putFile(
            'public/dokumen',
            $request->file('dokumen')
        );

        $input = $request->except(['dokumen']);

        // user yg login
        $input['user_id'] = auth()->id();
        $input['tgl_lahir'] = Carbon::createFromFormat('d/m/Y', $input['tgl_lahir'])->format('Y-m-d');
        $input['tgl_nik'] = Carbon::createFromFormat('d/m/Y', $input['tgl_nik'])->format('Y-m-d');

        if (auth()->user()->is_admin) {
            $user = User::create([
                'name' => $request->nama,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            $input = $request->except(['nama', 'username', 'password', 'password_confirmation', 'dokumen']);

            $input['tgl_lahir'] = Carbon::createFromFormat('d/m/Y', $input['tgl_lahir'])->format('Y-m-d');
            $input['tgl_nik'] = Carbon::createFromFormat('d/m/Y', $input['tgl_nik'])->format('Y-m-d');

            // simpan ke table anggota
            Anggota::create(array_merge($input, ['user_id' => $user->id]));

            return redirect()->route('anggota.index')->with('status', 'Anggota berhasil ditambahkan');
        }

        // simpan ke table anggota
        Anggota::create($input);

        return redirect()->route('home')->with('status', 'Data diri berhasil ditambahkan');
    }

    // proses menampilkan laporan
    public function apiLaporan(Request $request)
    {
        // mendapatkan pilihan tahun
        $year = $request->query('tahun');

        $pinjaman = new Pinjaman;
        $simpanan = new Simpanan;

        // proses mengubah data agar dapat dibaca oleh grafik
        // proses perulangan bulan dalam 1 tahun
        for ($i = 1; $i <= 12; $i++) {
            // mendapatkan nama bulan
            $dataSimpanan[$i]['label'] = date('F', mktime(0, 0, 0, $i, 1));
            $dataPinjaman[$i]['label'] = date('F', mktime(0, 0, 0, $i, 1));

            // query mendapaatkan data simpanan per bulan dalam setahun
            if ($total_simpanan = $simpanan->whereYear('created_at', $year)->whereMonth('created_at', $i)->sum('total_simpanan_sukarela')) {
                // (simpanan_pokok + simpanan_wajib) * total_data_simpanan_dalam_satu_bulan + total_simpanan
                $dataSimpanan[$i]['y'] = (int) (self::SIMPANAN_POKOK + self::SIMPANAN_WAJIB) * $simpanan->whereYear('created_at', $year)->whereMonth('created_at', $i)->count() + $total_simpanan;
            } else {
                $dataSimpanan[$i]['y'] = 0;
            }

            // query mendapaatkan data pinjaman per bulan dalam setahun
            $dataPinjaman[$i]['y'] = (int) $pinjaman->whereYear('created_at', $year)->whereMonth('created_at', $i)->sum('jumlah_pengajuan');
        }

        // proses merapihkan data dari proses perulangan / format data
        $dataSimpanan = array_reduce($dataSimpanan, function ($carry, $item) {
            array_push($carry, $item);
            return $carry;
        }, []);

        // proses merapihkan data dari proses perulangan / format data
        $dataPinjaman = array_reduce($dataPinjaman, function ($carry, $item) {
            array_push($carry, $item);
            return $carry;
        }, []);

        $data = [
            'simpanan' => $dataSimpanan,
            'pinjaman' => $dataPinjaman
        ];

        return response()->json($data);
    }
}
