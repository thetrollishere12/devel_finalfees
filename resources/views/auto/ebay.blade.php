@extends('layouts.noapp')


@section('others')
	<link rel="stylesheet" type="text/css" href="{{url('css/auto_account.css?5')}}">
@endsection
@section('title')

	Ebay Auto Seller Account Panel

@endsection()

@section('content')
<div class="load_ctn"><img class="preloader" src="{{ asset('image/preloader.gif') }}"></div>
	<div class="auto-inner">

		<div class="auto-list-container">

			<div class="auto-list">

				<a href="{{ URL::to('auto/ebay') }}"><h2 class="summary-tab summary-ebay sheet">Ebay</h2></a>

		 		<h2><a href="{{ URL::to('auto/etsy') }}">Etsy</a></h2> 

				<ul class="sheet-ul"></ul>

			</div>

		</div>

		<div class="auto-container">

<!-- 			<div class="load_ctn"><img class="preloader" src="image/preloader.gif"></div> -->

			<div id="auto_title">

				<a href="{{ URL::to('auto/ebay') }}"><div id="auto_account">Account</div></a>

<!-- 				<div>Auto</div> -->

				<!-- <div id="auto_import">Import Sales</div> -->

				<a href="{{ URL::to('auto/sold-item') }}"><div id="auto_sold">Sold Listing</div></a>

<!-- 				<div>Queue</div> -->

<!-- 				<div id="auto_active">Active Listing</div>  -->

			</div>

			<div class="auto-grid">	</div>

		</div>

	</div>

	@include('pg_widget.premium')



	<div class="alert popup_status">

		<button type="button" id="close_alert" class="close">&times;</button>

	</div>



<script type="text/javascript">

			$('#auto_account').addClass('select-blue');
			$.ajax({
	            url: "account",
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            },
	            method: "POST",
	            success: function(result) {
	                $(".auto-grid").empty().append(result);
	                $(".load_ctn").fadeOut();
	            },
	            error: function(request, status, error) {
	                $(".auto-grid").empty().append("Error")
	            }
	        });
</script>

@endsection