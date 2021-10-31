@extends('layouts.noapp')
@section('title')
    Verify
@endsection()
@section('others')
<link rel="stylesheet" type="text/css" href="{{ asset('css/password.css') }}">
@endsection

@section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            <br>{{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script type="text/javascript" src="../js/general.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>

@endsection
</html>


