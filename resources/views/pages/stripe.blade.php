@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your Stripe fees, costs, shipping and profits with our Stripe spreadsheet & fee calculator. Free Spreadsheet to record all of your sales.
@endsection

@section('title')
Stripe Fee Calculator & Spreadsheet - Calculate Your Stripe Fees
@endsection

@section('content')

<div id="main-calculator">
	<div class="main-container">
    	<h1>STRIPE FEE CALCULATOR</h1>
    	<div class="stripe-inner">
    		@include('pg_widget.name_date')
			@include('pg_widget.sold')


			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Select Stripe rate.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Stripe Rate</div>
				</div>
				<div>
					<select name="stripe-rate">
						<option disabled>Paypal Domestic</option>
						<option value="1">2.9% + $0.30 (Online Transaction)</option>
					</select>
				</div>
			</div>
			@include('pg_widget.tax')
            @include('pg_widget.currency')

			<div class="fee_profit-container">
				@include('inc.stripe_slide')
				@include('pg_widget.profit')
				@include('pg_widget.add_to_sheet')
				@include('pg_widget.premium')
			</div>
			@include('inc.ad')
		</div>
	</div>
	<div class="details-container">
		<div class="about-container">
			<h2>ABOUT STRIPE FEES</h2>
			<p>Stripe is a company very similar to Paypal that offers services which allows businesses to receive online transactions. For majority of all Stripe transactions, you will be charged a Stripe transaction fee at 2.9% + $0.30. Stripe transaction fee may also vary based on location, type of currency and method.</p>
		</div>
		@include('inc.graph')
	</div>
</div>
		
@endsection

