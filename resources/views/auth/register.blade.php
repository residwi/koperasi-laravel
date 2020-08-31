@extends('auth.master')

{{-- Title --}}
@section('title', 'Laravel - Register')

@section('auth-content')
<p class="login-box-msg">Register a new account</p>

<form action="{{ route('register') }}" method="POST">
    @csrf
    <div class="input-group mb-3">
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
            value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-pencil-alt"></span>
            </div>
        </div>
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="input-group mb-3">
        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
            value="{{ old('username') }}" required autocomplete="username" placeholder="Username">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
        @error('username')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="input-group mb-3">
        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required
            autocomplete="new-password" placeholder="Password">
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
    <div class="input-group mb-3">
        <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"
            placeholder="Retype password">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <a href="{{ route('login') }}" class="text-center">I already have an account</a>
        </div>
        <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </div>
    </div>
</form>
@endsection