@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your Depop Paypal fees, shipping amount and profits with our Depop spreadsheet & fee calculator. Free Spreadsheet to record all of your sales.
@endsection()

@section('title')
Depop Paypal Fee Calculator & Spreadsheet - Calculate Depop Fee.
@endsection()

@section('content')

<div id="main-calculator">
	<div class="main-container">
    	<h1>DEPOP FEE CALCULATOR</h1>
		<div class="depop-inner">
			@include('pg_widget.name_date')
			@include('pg_widget.sold')
			@include('pg_widget.ship_charge')
			@include('pg_widget.ship_cost')
			@include('pg_widget.cost')
			@include('pg_widget.tax')
			@include('pg_widget.currency')

			<div class="fee_profit-container">
				<div class="fee_profit-inner"><span><b class="pg-name">Depop Fee: </b></span><span id="main-fees">0</span></div>
				@include('inc.paypal_slide')
				@include('pg_widget.profit')
				@include('pg_widget.add_to_sheet')
				@include('pg_widget.premium')
			</div>
			@include('inc.ad')
		</div>
	</div>
	<div class="details-container">

		<div class="about-container">
			<a href="{{ url('auto/ebay')}}"><h2 class="bbb">TRY OUR ETSY SALE EXTENSION</h2></a>
			<p>You can now import <span class="bb">hundreds</span> of your sold listings in a <span class="bb">heartbeat</span> with all the <span class="bb">fees & profits</span> without having to do a thing! Now available on <span class="bb">Google Chrome Web Store</span>.
			<br><a href="{{ url('auto/ebay')}}"><button>Click Here To Try It Now</button></a><a href="{{ url('tutorial-autosheet')}}"><button>Click Here For Tutorial</button></a>
			<br>
			</p>
		</div>


		<div class="about-container about-fees">
			<h2>ABOUT DEPOP FEES</h2>
			<p>Depop is an online fasion marketplace focused on unique items, vintage & luxury fashion, art and books. For each time a transaction is made, Depop collects 10% of the total sold price including shipping charges plus <a href="{{url('/paypal')}}">Paypal fees</a>.</p>
		</div>
		@include('inc.graph')
	</div>
</div>

@endsection
