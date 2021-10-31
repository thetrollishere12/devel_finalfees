@extends('layouts.noapp')

@section('title')
	Your Spreadsheets
@endsection()

@section('content')
<div class="load_ctn" id="loader"><img class="preloader" src="{{ asset('image/preloader.gif') }}"></div>
<div class="msg animate slide-in-down"></div>

<div class="extension-container"></div>
<div class="extension-sheet">
    <button class="delete-selected-sales delete-selected-disabled" disabled>Delete Selected Sales</button>
	@if(isset(Auth::user()->email_verified_at))
	    <div id="list"></div>
	    <div>
	        <button class="create_sheet" data-toggle="modal" data-target="#add_page">Create Spreadsheet</button>
	    </div>
    @endif
</div>
	@include('pg_widget.premium')
	@include('pg_widget.add_sheet')


<div class="alert popup_status">
	<button type="button" id="close_alert" class="close">&times;</button>
</div>

@endsection