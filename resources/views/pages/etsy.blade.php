@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your Etsy paypal fees, processing fees, shipping amount and profits with our Etsy spreadsheet & fee calculator.Free Spreadsheet to record all of your sales
@endsection()

@section('title')
Etsy Fee Calculator - Calculate Etsy Fees Paypal Processing Fee
@endsection()

@section('content')

	
<div id="main-calculator">
	<div class="main-container">
    	<h1>ETSY PAYPAL FEE CALCULATOR</h1>
	    <div class="etsy-inner">
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
					            <p>Enter the amount you paid for advertisement.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Advertising Cost</div>
				</div>
				<div><input type="number" name="ad_cost"></div>
			</div>
			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Select payment method type.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Payment Method</div>
				</div>
				<div>
					<select name="etsy_payment">
						<option disabled>Etsy Direct Checkout</option>
						<option value="1" selected>3% + $0.25</option>
						<option disabled>Paypal Domestic</option>
						<option>2.9% + $0.30</option>
						<option>2.5% + $0.30</option>
						<option>2.2% + $0.30</option>
						<option disabled>Paypal International</option>
						<option>4.4% + $0.30</option>
						<option disabled>Paypal Nonprofit</option>
						<option>2.9% + $0.30</option>
						<option disabled>Paypal Micropayment</option>
						<option>5% + $0.05</option>
					</select>
				</div>
			</div>
			@include('pg_widget.tax')
			@include('pg_widget.currency')
			<div class="fee_profit-container">
				<div class="fee_profit-inner"><span><b class="pg-name">Etsy Fee: </b></span><span id="main-fees">0</span></div>
				<div class="fee_profit-inner"><span><b>Tax: </b></span><span id="main-tax"></span></div>
				@include('inc.processing_slide')
				@include('pg_widget.profit')
				@include('pg_widget.add_to_sheet')
				@include('pg_widget.premium')
			</div>
			@include('inc.ad')
		</div>
	</div>
	<div class="details-container">

		<div class="about-container">
			<a href="{{ url('auto/etsy')}}"><h2 class="bbb">TRY OUR INSTANT ETSY FEE SYSTEM</h2></a>
			<p>You can now calculate <span class="bb">hundreds</span> of your sold listings in a <span class="bb">heartbeat</span> with all the <span class="bb">Etsy & Transaction fees</span> without having to do a thing! All you have to do is connect with your Etsy account and that's it.
			<br><a href="{{ url('auto/etsy')}}"><button>Click Here To Try It Now</button></a><a href="{{ url('tutorial-autosheet')}}"><button>Click Here For Tutorial</button></a>
			<br>
			</p>
		</div>

		<div class="about-container about-fees">
			<h2>ABOUT ETSY FEES</h2>
			<p>Etsy is an online retail marketplace focused on vintage and handmade items. Etsy has 2 types of fees; Listing fees at $0.20 for each item you list and transaction fees at 5% of total sold price and shipping combined. <a href="{{url('/paypal')}}">Paypal</a> or Processing fees will be included depending on the payment method you choose.</p>
		</div>
		@include('inc.graph')
	</div>
</div>
	
@endsection

