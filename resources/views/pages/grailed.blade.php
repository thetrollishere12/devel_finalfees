@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your {{date("Y")}} Grailed Paypal fees, shipping and profits with our Grailed Spreadsheet & fee calculator. Free Spreadsheet to record all of your sales.
@endsection

@section('title')
Grailed Paypal Fee Calculator & Spreadsheet
@endsection

@section('content')

<div id="main-calculator">
	<div class="main-container">
    	<h1>GRAILED PAYPAL FEE CALCULATOR</h1>
    	<div class="grailed-inner">
    		@include('pg_widget.name_date')
			@include('pg_widget.sold')
			@include('pg_widget.ship_charge')
			@include('pg_widget.ship_cost')
			@include('pg_widget.cost')
			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Select the payment method you received based on buyer's location.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Paypal Method</div>
				</div>
				<div>
					<select name="paypal_method" id="paypal_method">
						<option value="2.9">Domestic (2.9% + $0.30)</option>
						<option value="4.4">International (4.4% + $0.30)</option>
					</select>
				</div>
			</div>
			@include('pg_widget.tax')
            @include('pg_widget.currency')
			<div class="fee_profit-container">
				<div class="fee_profit-inner"><span><b class="pg-name">Grailed Fee: </b></span><span id="main-fees">0</span></div>
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
			<a href="{{ url('auto/ebay')}}"><h2 class="bbb">TRY OUR GRAILED SALE EXTENSION</h2></a>
			<p>You can now import <span class="bb">hundreds</span> of your sold listings in a <span class="bb">heartbeat</span> with all the <span class="bb">fees & profits</span> without having to do a thing! Now available on <span class="bb">Google Chrome Web Store</span>.
			<br><a href="{{ url('auto/ebay')}}"><button>Click Here To Try It Now</button></a><a href="{{ url('tutorial-autosheet')}}"><button>Click Here For Tutorial</button></a>
			<br>
			</p>
		</div>

		<div class="about-container">
			<h2>ABOUT GRAILED FEES</h2>
			<p>Grailed is an online fasion marketplace focused on vintage, high-end, and popular street brands such as, Champion, Nike or Gucci. Free for many users to make an account, Grailed offers low fees for sellers. For each time a transaction is made grailed takes a 9% commission of the sold price plus <a href="{{url('/paypal')}}">Paypal fees</a>.</p>
		</div>
		@include('inc.graph')
	</div>
</div>
	
@endsection
