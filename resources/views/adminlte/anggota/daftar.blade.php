@extends('adminlte.layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Silahkan lengkapi data diri dahulu.</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('daftar-anggota') }}" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" class="form-control" value="{{ $nama }}" disabled>
                </div>
                <div class="form-group col-md-6">
                    <label for="tgl_lahir">Tanggal Lahir</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input id="tgl_lahir" type="text" class="form-control @error('tgl_lahir') is-invalid @enderror"
                            name="tgl_lahir" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy"
                            data-mask placeholder="17/08/1945" value="{{ old('tgl_lahir') }}" required>
                    </div>
                    @error('tgl_lahir')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <h5 class="mt-3">Pekerjaan</h5>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="perusahaan">Nama Perusahaan</label>
                        <input type="text" id="perusahaan"
                            class="form-control @error('perusahaan') is-invalid @enderror" name="perusahaan"
                            value="{{ old('perusahaan') }}" required>
                        @error('perusahaan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nik">No NIK</label>
                        <input type="text" id="nik" class="form-control @error('nik') is-invalid @enderror" name="nik"
                            value="{{ old('nik') }}" required>
                        @error('nik')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tgl_nik">Tanggal NIK / Tanggal Masuk Kerja</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input id="tgl_nik" type="text" class="form-control @error('tgl_nik') is-invalid @enderror"
                                name="tgl_nik" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy"
                                data-mask placeholder="{{ date('d/m/Y') }}" value="{{ old('tgl_nik') }}" required>
                        </div>
                        @error('tgl_nik')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="divisi">Divisi</label>
                        <input type="text" id="divisi" class="form-control @error('divisi') is-invalid @enderror"
                            name="divisi" value="{{ old('divisi') }}" required>
                        @error('divisi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bagian">Bagian</label>
                        <input type="text" id="bagian" class="form-control @error('bagian') is-invalid @enderror"
                            name="bagian" value="{{ old('bagian') }}" required>
                        @error('bagian')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="golongan">Golongan</label>
                        <input type="text" id="golongan" class="form-control @error('golongan') is-invalid @enderror"
                            name="golongan" value="{{ old('golongan') }}" required>
                        @error('golongan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <h5 class="mt-3">Pendapatan</h5>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="upah_pokok">Upah Pokok</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control @error('upah_pokok') is-invalid @enderror"
                                id="upah_pokok" name="upah_pokok" value="{{ old('upah_pokok') }}" required>
                            @error('upah_pokok')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gaji">Total Gaji</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control @error('gaji') is-invalid @enderror" id="gaji"
                                name="gaji" value="{{ old('gaji') }}" required>
                        </div>
                        @error('gaji')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tunjangan_jabatan">Tunjangan Jabatan</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control @error('tunjangan_jabatan') is-invalid @enderror"
                                id="tunjangan_jabatan" name="tunjangan_jabatan" value="{{ old('tunjangan_jabatan') }}"
                                required>
                        </div>
                        @error('tunjangan_jabatan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <h5 class="mt-3">Simpanan</h5>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="simpanan_pokok">Simpanan Pokok</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" class="form-control" id="simpanan_pokok" value="100.000" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="simpanan_sukarela">Simpanan Sukarela</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control @error('simpanan_sukarela') is-invalid @enderror"
                                id="simpanan_sukarela" name="simpanan_sukarela" value="{{ old('simpanan_sukarela') }}"
                                required>
                        </div>
                        @error('simpanan_sukarela')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="simpanan_wajib">Simpanan Wajib</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" class="form-control" id="simpanan_wajib" value="50.000" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success mt-3">Submit</button>
        </form>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<script>
    $(function () {
        $('[data-mask]').inputmask()
    })
</script>
@endpush