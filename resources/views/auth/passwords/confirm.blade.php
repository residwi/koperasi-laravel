@extends('auth.master')

{{-- Title --}}
@section('title', "Confirm Password")

@section('auth-content')
<p class="login-box-msg">Please confirm your password before continuing.</p>

<form action="{{ route('password.confirm') }}" method="POST">
    @csrf
    <div class="input-group mb-3">
        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required
            autocomplete="current-password" placeholder="Password">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>

        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="row">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Confirm Password</button>
        </div>
    </div>
</form>

@if (Route::has('password.request'))
<p class="mb-1 mt-3">
    <a href="{{ route('password.request') }}">I forgot my password</a>
</p>
@endif
@endsection