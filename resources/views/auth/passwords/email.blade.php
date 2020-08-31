@extends('auth.master')

{{-- Title --}}
@section('title', "Laravel - Forgot Password")

@section('auth-content')
<p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<form action="{{ route('password.email') }}" method="POST">
    @csrf
    <div class="input-group mb-3">
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>

        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="row">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
        </div>
    </div>
</form>

@if (Route::has('login'))
<p class="mb-1 mt-3">
    <a href="{{ route('login') }}">Login</a>
</p>
@endif

@if (Route::has('register'))
<p class="mb-0">
    <a href="{{ route('register') }}" class="text-center">Register a new account</a>
</p>
@endif
@endsection