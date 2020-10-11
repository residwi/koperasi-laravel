@extends('adminlte.layouts.app')

@section('title', 'Tambah Simpanan')

@push('css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Simpanan</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('simpanan.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="anggota">Anggota</label>
                        <select name="anggota" class="form-control select2" id="anggota">
                            <option disabled selected>Pilih Nama Anggota</option>
                            @foreach ($anggota as $item)
                            <option value="{{ $item->id }}">{{ $item->user->name }}</option>
                            @endforeach
                        </select>
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
                        <label for="simpanan_pokok">Simpanan Pokok</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" class="form-control" id="simpanan_pokok" value="100.000" disabled>
                        </div>
                    </div>
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
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection

@push('js')
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
      $('.select2').select2({
        theme: 'bootstrap4'
      });
    });
</script>
@endpush