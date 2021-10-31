@extends('layouts.noapp')
@section('title')
    Register
@endsection()
@section('others')
<link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
@endsection
@section('content')
<div class="login-container">
    <div class="header">{{ __('Register') }}</div>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <a href="{{ url('/google-login') }}" class="google_ctn"><img class="google_sign_in" src="{{ asset('image/g_login.png') }}"> Sign Up With Google</a>
        <div class="or">or</div>
        <div>
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
        </div>
        @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
        <div>
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
        </div>
        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
        <div>
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
        </div>
        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
        <div>
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
        </div>

        <div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
        @if($errors->has('g-recaptcha-response'))
            <div><b style="color:#ff3d50!important;">{{ $errors->first('g-recaptcha-response') }}</b></div>
        @endif

        <button type="submit" class="register-btn">
            {{ __('Register') }}
        </button>
        <a href="{{url('/login')}}">Already have an account?</a>
    </form>
</div>


@endsection
