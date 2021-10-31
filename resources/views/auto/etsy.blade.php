@extends('layouts.noapp')


@section('others')
    <link rel="stylesheet" type="text/css" href="{{asset('css/ebay_auto.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/auto_account.css')}}">
@endsection
@section('title')

	Ebay Auto Seller Account Panel

@endsection()

@section('content')
<div class="load_ctn"><img class="preloader" src="{{ asset('image/preloader.gif') }}"></div>
	<div class="auto-inner">

		<div class="auto-list-container">

			<div class="auto-list">

				<a href="{{ URL::to('auto/etsy') }}"><h2 class="summary-tab summary-ebay sheet">Etsy</h2></a>

		 		<a href="{{ URL::to('auto/ebay') }}"><h2>Ebay</h2></a> 

				<ul class="sheet-ul"></ul>

			</div>

		</div>

		<div class="auto-container">

<!-- 			<div class="load_ctn"><img class="preloader" src="image/preloader.gif"></div> -->

			<div id="auto_title">

				<a href="{{ URL::to('auto/etsy') }}"><div id="auto_account">Account</div></a>

				<a href="{{ URL::to('auto/etsy/sold-item') }}"><div id="auto_sold">Sold Listing</div></a>

                <a href="{{ URL::to('auto/etsy/billing-fees') }}"><div id="auto_billing">Billing & Fees</div></a>

			</div>

			<div class="auto-grid">	</div>
            <div class="endorsed-line">The term 'Etsy' is a trademark of Etsy, Inc.<br>This application uses the Etsy API but is not endorsed or certified by Etsy.</div>
		</div>

	</div>

    @if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
    @elseif(\Session::has('error'))
    <div class="alert" style="background:#c82333 !important;">
        <ul>
            <li>{!! \Session::get('error') !!}</li>
        </ul>
    </div>
    @endif

	@include('pg_widget.premium')



	<!--<div class="alert popup_status">-->

	<!--	<button type="button" id="close_alert" class="close">&times;</button>-->
 <!--       <div class="alert-message"></div>-->
	<!--</div>-->


<style>
    .endorsed-line{
        color:#262626;
        text-align:center;
        font-size:12px;
        padding:9px 0px;
    }
    
    .alert ul{
        list-style:none;
    }
</style>
<script type="text/javascript">

			$('#auto_account').addClass('select-blue');
			
			$.ajax({
	            url: "{{url('')}}/etsy/account",
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            },
	            method: "GET",
	            success: function(result) {
                    $(".auto-grid").empty().append(result);
                    $('#tooltips').show();
	                $(".load_ctn").fadeOut();
	            },
	            error: function(request, status, error) {
	                $(".auto-grid").empty().append("Error")
	            }
	        });
	        
</script>

@endsection 