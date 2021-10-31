@extends('layouts.noapp')
@section('title')
	Home
@endsection()
@section('content')

<div class="email-container">
@foreach($emails as $email)
	<div class="email-container-list">
		<div>{{ $email->buyer_email }}</div>
		<div>{{ $email->name }}</div>
	</div>
@endforeach
</div>
<style type="text/css">

	.email-container{
		max-width: 800px;
		margin: auto;
	}

	.email-container-list{
		border:solid 1px rgba(0,0,0,.1);
		padding:5px 5px 5px 8px;
		border-radius: 4px;
		margin:3px 0px;
		transition: .3s;
	}

	.email-container-list:hover{
		background: #f26223;
		color: white;
		cursor: pointer;
	}
</style>

@endsection
