@extends('layouts.noapp')
@section('title')
	Home
@endsection()
@section('content')
<div class="home-container">
    <h2>Account:{{ Auth::user()->name }}</h2>
    <div class="home-list">
        <a href="{{url('/settings')}}"><div>Account Settings</div></a>
        <a href="{{url('/spreadsheet')}}"><div>View My Spreadsheets</div></a>
        <a href="{{url('/auto')}}"><div>View My Auto System</div></a>
        <a href="{{url('/subscription')}}"><div>View Subscription</div></a>
        <a href="{{url('/message')}}"><div>Contact Us</div></a>
    </div>
</div>
@endsection
