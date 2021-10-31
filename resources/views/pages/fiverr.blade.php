@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your Fiverr Fee, Paypal fees and profits with our Fiverr spreadsheet & fee calculator. Free Spreadsheet to record all of your sales.
@endsection()

@section('title')
Fiverr Fee Calculator. Calculate Your Paypal Fee & Fiverr Fees.
@endsection()

@section('content')
<div id="main-calculator">
	<div class="main-container">
    	<h1>FIVERR FEE CALCULATOR</h1>
		<div class="fiverr-inner">
			@include('pg_widget.name_date')
			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					         	<p>Enter amount charged to the customer/client.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Amount Charging</div>
				</div>
				<div><input type="number" name="sold_price"></div>
			</div>
			@include('pg_widget.tax')
			@include('pg_widget.currency')
			<div class="fee_profit-container">
				<div class="fee_profit-inner"><span><b class="pg-name">Fiverr Fee: </b></span><span id="main-fees">0</span></div>
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
			<h2>ABOUT FIVERR FEES</h2>
			<p>Fiverr is an online marketplace where freelancers offer services to customers worldwide. Each transaction Fiverr takes a fee of 20% of the total amount freelancers earn plus <a href="{{url('/paypal')}}">Paypal fees</a>.</p>
		</div>
		@include('inc.graph')
	</div>
</div>

@endsection
