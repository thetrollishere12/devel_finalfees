@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your Facebook marketplace fees, shipping amount and profits with our Facebook spreadsheet & fee calculator. Free spreadsheet to record all of your sales.
@endsection()

@section('title')
Facebook Fee Calculator & Spreadsheet - Calculate Facebook Fee.
@endsection()

@section('content')

<div id="main-calculator">
	<div class="main-container">
    	<h1>FACEBOOK MARKETPLACE FEE CALCULATOR</h1>
		<div class="main-inner">
			@include('pg_widget.name_date')

			@include('pg_widget.sold')
			@include('pg_widget.cost')

			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					        	<p>If shipping to the buyer.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div class="input-container-txt">Shipping</div>
				</div>
				<div>
					<select name="shipping_option">
						<option value="no">No</option>
						<option value="yes">Yes</option>
					</select>
				</div>
			</div>

			<div class="shipping-container">
				@include('pg_widget.ship_charge')
				@include('pg_widget.ship_cost')
			</div>

			
			@include('pg_widget.tax')
			@include('pg_widget.currency')

			<div class="fee_profit-container">
				<div class="fee_profit-inner"><span><b class="pg-name">Facebook Fee: </b></span><span id="main-fees">0</span></div>
				<div class="fee_profit-inner"><span><b>Tax: </b></span><span id="main-tax"></span></div>
				<div class="button-container">
					<button class="p-reset" name="p-reset">Reset</button>
				</div>
				@include('pg_widget.profit')
				@include('pg_widget.add_to_sheet')
				@include('pg_widget.premium')
			</div>
			@include('inc.ad')
		</div>
	</div>
	<div class="details-container">
		<div class="about-container">
			<h2>ABOUT FACEBOOK FEES</h2>
			<p>Facebook is an online digital marketplace where facebook users can set up listings to sell/trade or arrange to buy with other people around their local area. There is a 5% selling fee or a flat $0.40 for transactions from $8 or less depending on your listing on Facebook Marketplace.</p>
		</div>
		@include('inc.graph')
	</div>
</div>

<style type="text/css">
	
	.shipping-container{
		display: none;
	}

</style>

@endsection
