@extends('layouts.noapp')
@section('title')
    Login
@endsection()
@section('others')
<link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-container">
    <div class="header">{{ __('Login') }}</div>
    <form method="POST" action="{{ route('login') }}">
        @csrf
            <div>
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label><br>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            <div>
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label><br>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
            </div>
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
<!-- 
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div> -->
            <button type="submit" class="login-btn">
                {{ __('Login') }}
            </button>
            <a href="{{ url('/google-login') }}" class="google_ctn"><img class="google_sign_in" src="{{ asset('image/g_login.png') }}"> Log In With Google</a>

            @if (Route::has('password.request'))
            <p>
                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            </p>
            @endif
    </form>
</div>



@endsection
