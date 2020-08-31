@extends('adminlte.layouts.app')

@section('title', 'Edit Simpanan')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Simpanan</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('simpanan.update', $simpanan->id) }}">
            @csrf
            @method('PUT')
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
                                id="simpanan_sukarela" name="simpanan_sukarela" value="{{ $simpanan->simpanan_sukarela }}"
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
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection