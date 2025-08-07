{{-- filepath: resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    body {
        background: rgba(173, 169, 180, 0.95);
        background-size: cover;
    }
    .login-card {
        background: rgba(65, 57, 78, 0.95);
        border-radius: 1rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
        padding: 2rem 2.5rem;
        margin-top: 3rem;
    }
    .login-logo {
        width: 80px;
        height: 80px;
        object-fit: contain;
        margin-bottom: 1rem;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem #ffb34733;
        border-color: #ffb347;
    }
    .btn-primary {
        background: linear-gradient(90deg, #ffb347 0%, #ffcc33 100%);
        border: none;
        color: #222;
        font-weight: bold;
        letter-spacing: 1px;
    }
    .btn-primary:hover {
        background: linear-gradient(90deg, #ffcc33 0%, #ffb347 100%);
        color: #111;
    }
    .card-header {
        background: transparent;
        border-bottom: none;
        text-align: center;
        font-size: 1.5rem;
        font-weight: bold;
        color: #ffb347;
    }
    .input-group-text {
        background: #fff8e1;
        border: none;
        color: #ffb347;
    }
</style>
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 90vh;">
        <div class="col-md-6 col-lg-5">
            <div class="card login-card">
                <div class="card-header">
                    <h1 class="m-0 fw-extrabold fs-2" style="letter-spacing: 0.06em; color: #FF4E00;">
        <span style="font-style: italic; font-weight: 700;">Rest</span>
        <span style="color: #ffffff; font-weight: 900; margin-left: 4px;">Food</span>
      </h1>
                </div>
                <div class="{{ app()->getLocale() == 'ar' ? 'me-2' : 'ms-2' }} card-body english-data-font">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3 english-data-font">
                            <label for="username" style="color: #ffffff;" class="form-label">{{ __('words.username') }}</label>
                            <div class="input-group text-white english-data-font">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                                <input id="username" type="text" class="form-control english-data-font @error('username') is-invalid @enderror"
                                    name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                @error('username')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 text-white">
                            <label for="password" class="form-label">{{ __('words.password') }}</label>
                            <div class="input-group text-white english-data-font">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                <input id="password" type="password" class="english-data-font form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 form-check text-white">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('words.remember_me') }}
                            </label>
                        </div>

                        <div class="d-grid mb-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-sign-in-alt"></i> {{ __('words.login') }}
                            </button>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-center text-white">
                                <a class="btn btn-link text-white" href="{{ route('password.request') }}">
                                    {{ __('words.forgot_password') }}
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection