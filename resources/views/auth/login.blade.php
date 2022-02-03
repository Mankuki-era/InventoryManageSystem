@extends('layouts.app')

@push('css')
  <link href="{{ asset('css/user/login.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="wrapper">
    <main>
        <div class="empty">
            <h1>
                <a href="../index.html">
                    <p class="h1_sub main_title">情報通信工学科実験室</p>
                    <p class="main_title2">在庫管理システム</p>
                    <p class="main_title2">ログインページ</p>
                </a>
            </h1>
        </div>
        <div class="login_control">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <h2>LOGIN</h2>
                <p class="named_ID">STAFF NUMBER</p>
                <input type="number" name="number" value="{{ old('number') }}" maxlength="5" step="1" class="FormOfms @error('number') is-invalid @enderror" required autofocus>
                @error('number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <p class="named_ID">PASSWORD</p>
                <input type="password" name="password" class="FormOfms @error('password') is-invalid @enderror" autocomplete="current-password" required>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <div class="form_check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>


                <div>
                    <button type="submit" class="login_button">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="forgot_link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </main>
</div>
@endsection