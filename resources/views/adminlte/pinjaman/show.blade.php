@extends('adminlte.layouts.app')

@section('title', 'Form Pengajuan Pinjaman')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Data Anggota</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" class="form-control" value="{{ $pinjaman->anggota->user->name }}"
                        disabled>
                </div>
                <div class="form-group">
                    <label for="tgl_lahir">Tanggal Lahir</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input id="tgl_lahir" type="text" class="form-control" data-inputmask-alias="datetime"
                            data-inputmask-inputformat="dd/mm/yyyy" data-mask
                            value="{{ \Carbon\Carbon::parse($pinjaman->anggota->tgl_lahir)->format('d-m-Y') }}"
                            disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="perusahaan">Nama Perusahaan</label>
                    <input type="text" id="perusahaan" class="form-control" value="{{ $pinjaman->anggota->perusahaan }}"
                        disabled>
                </div>
                <div class="form-group">
                    <label for="nik">No NIK</label>
                    <input type="text" id="nik" class="form-control" value="{{ $pinjaman->anggota->nik }}" disabled>
                </div>
                <div class="form-group">
                    <label for="tgl_nik">Tanggal NIK / Tanggal Masuk Kerja</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input id="tgl_nik" type="text" class="form-control" data-inputmask-alias="datetime"
                            data-inputmask-inputformat="dd/mm/yyyy" data-mask
                            value="{{ \Carbon\Carbon::parse($pinjaman->anggota->tgl_nik)->format('d-m-Y') }}" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Masuk Kerja</label>
                    <div class="input-group">
                        <input type="text" class="form-control" value="{{ $masa_kerja->y . ' Tahun' }}" disabled>
                        <input type="text" class="form-control" value="{{ $masa_kerja->m . ' Bulan'}}" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="divisi">Divisi</label>
                    <input type="text" id="divisi" class="form-control" value="{{ $pinjaman->anggota->divisi }}"
                        disabled>
                </div>
                <div class="form-group">
                    <label for="bagian">Bagian</label>
                    <input type="text" id="bagian" class="form-control" value="{{ $pinjaman->anggota->bagian }}"
                        disabled>
                </div>
                <div class="form-group">
                    <label for="golongan">Golongan</label>
                    <input type="text" id="golongan" class="form-control" value="{{ $pinjaman->anggota->golongan }}"
                        disabled>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pendapatan</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="upah_pokok">Upah Pokok</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                        </div>
                        <input type="text" class="form-control" id="upah_pokok"
                            value="{{ number_format($pinjaman->anggota->upah_pokok) }}" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gaji">Total Gaji</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                        </div>
                        <input type="text" class="form-control" id="gaji"
                            value="{{ number_format($pinjaman->anggota->gaji) }}" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tunjangan_jabatan">Tunjangan Jabatan</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                        </div>
                        <input type="text" class="form-control" id="tunjangan_jabatan"
                            value="{{ number_format($pinjaman->anggota->tunjangan_jabatan) }}" disabled>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Pengajuan</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="keperluan">Untuk Keperluan</label>
                            <textarea style="resize: none;" id="keperluan" class="form-control" rows="3" placeholder="Keperluan"
                                disabled>{{ $pinjaman->keperluan }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="jenis_pinjaman">Jenis Pinjaman</label>
                            <input type="text" id="jenis_pinjaman" class="form-control"
                                value="{{ $pinjaman->jenis_pinjaman->nama }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_pengajuan">Jumlah Pengajuan Pinjaman</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" id="jumlah_pengajuan" class="form-control" disabled
                                    value="{{ $pinjaman->jumlah_pengajuan }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea style="resize: none;" id="keterangan" class="form-control" rows="3" placeholder="Keterangan"
                                disabled>{{ $pinjaman->keterangan }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="angsuran_yang_disanggupi"> Angsuran Pinjaman Yang Disanggupi</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" id="angsuran_yang_disanggupi" class="form-control" disabled
                                    value="{{ $pinjaman->angsuran_yang_disanggupi }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-2 float-right">
                    <a href="{{ Storage::url($pinjaman->dokumen) }}" class="btn btn-primary" target="_blank">Lihat
                        Dokumen</a>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection