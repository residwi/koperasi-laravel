@extends('adminlte.layouts.app')

@section('title', 'Bayar Angsuran')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Bayar Angsuran</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('pinjaman.angsuran.store', $pinjaman->id) }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input id="tanggal" type="text" class="form-control"
                                value="{{ Carbon\Carbon::parse(now())->format('d-m-Y') }}" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sisa_pinjaman">Sisa Pinjaman</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" id="sisa_pinjaman"
                                value="{{ $sisa_pinjaman }}" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_angsuran">Jumlah Angsuran</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control @error('jumlah_angsuran') is-invalid @enderror"
                                id="jumlah_angsuran" name="jumlah_angsuran" value="{{ old('jumlah_angsuran') ?? $pinjaman->angsuran_yang_disanggupi }}"
                                required>
                        </div>
                        @error('jumlah_angsuran')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection