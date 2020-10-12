@extends('adminlte.layouts.app')

@section('title', 'Ajukan Peminjaman')

@push('css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Ajukan Peminjaman</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('pinjaman.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="anggota">Nama Anggota</label>
                    <select name="anggota" class="form-control select2bs4" id="anggota">
                        <option disabled selected>Pilih Nama Anggota</option>
                        @foreach ($anggota as $item)
                        <option value="{{ $item->id }}">{{ $item->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="tgl_lahir">Tanggal Lahir</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input id="tgl_lahir" type="text" class="form-control" disabled>
                    </div>
                </div>
            </div>
            <h5 class="mt-3">Pekerjaan</h5>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="perusahaan">Nama Perusahaan</label>
                        <input type="text" id="perusahaan" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nik">No NIK</label>
                        <input type="text" id="nik" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="tgl_nik">Tanggal NIK / Tanggal Masuk Kerja</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input id="tgl_nik" type="text" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Masuk Kerja</label>
                        <div class="input-group">
                            <input type="text" class="form-control" disabled>
                            <input type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="divisi">Divisi</label>
                        <input type="text" id="divisi" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="bagian">Bagian</label>
                        <input type="text" id="bagian" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="golongan">Golongan</label>
                        <input type="text" id="golongan" class="form-control" disabled>
                    </div>
                </div>
            </div>
            <h5 class="mt-3">Pendapatan</h5>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="upah_pokok">Upah Pokok</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" class="form-control" id="upah_pokok" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="gaji">Total Gaji</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" class="form-control" id="gaji" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tunjangan_jabatan">Tunjangan Jabatan</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" class="form-control" id="tunjangan_jabatan" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="mt-3">Mengajukan permohonan pinjaman</h5>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="keperluan">Untuk Keperluan</label>
                        <textarea name="keperluan" id="keperluan"
                            class="form-control @error('keperluan') is-invalid @enderror" rows="3"
                            placeholder="Keperluan" required>{{ old('keperluan') }}</textarea>
                        @error('keperluan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Jenis Pinjaman</label>
                        <select class="form-control select2bs4 @error('jenis_pinjaman') is-invalid @enderror"
                            style="width: 100%;" name="jenis_pinjaman" required>
                            <option disabled selected>Pilih Jenis Pinjaman</option>
                            @foreach ($jenis_pinjaman as $item)
                            <option value="{{ $item->id }}">{{ $item->nama . " - ($item->kelengkapan_dokumen)" }}
                            </option>
                            @endforeach
                        </select>
                        @error('jenis_pinjaman')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jumlah_pengajuan">Jumlah Pengajuan Pinjaman</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" id="jumlah_pengajuan"
                                class="form-control @error('jumlah_pengajuan') is-invalid @enderror"
                                name="jumlah_pengajuan" required value="{{ old('jumlah_pengajuan') }}">
                        </div>
                        @error('jumlah_pengajuan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan"
                            class="form-control @error('keterangan') is-invalid @enderror" rows="3"
                            placeholder="Keterangan">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="dokumen">Upload Dokumen</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('dokumen') is-invalid @enderror"
                                id="dokumen" name="dokumen" required>
                            <label class="custom-file-label" for="dokumen">Choose file</label>
                        </div>
                        @error('dokumen')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="angsuran_yang_disanggupi"> Angsuran Pinjaman Yang Disanggupi</label>
                        <label class="float-right">
                            <small class="form-text">Maks. angsuran / bulan =
                                <strong>35 % x ( Total UP )</strong>
                            </small>
                        </label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" id="angsuran_yang_disanggupi"
                                class="form-control @error('angsuran_yang_disanggupi') is-invalid @enderror"
                                name="angsuran_yang_disanggupi" required value="{{ old('angsuran_yang_disanggupi') }}">
                        </div>
                        @error('angsuran_yang_disanggupi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-success">Submit</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2bs4').select2({
          theme: 'bootstrap4',
        });

        bsCustomFileInput.init();

        $('#anggota').on('select2:select', function (e) {
            var data = e.params.data;
            $.get("/api/anggota/" + data.id, function( data ) {
                $('#tgl_lahir').val(data.tgl_lahir);
                $('#perusahaan').val(data.perusahaan);
                $('#nik').val(data.nik);
                $('#tgl_nik').val(data.tgl_nik);
                $('#divisi').val(data.divisi);
                $('#bagian').val(data.bagian);
                $('#golongan').val(data.golongan);
                $('#upah_pokok').val(data.upah_pokok);
                $('#gaji').val(data.gaji);
                $('#tunjangan_jabatan').val(data.tunjangan_jabatan);
            });
        });
    });
</script>
@endpush