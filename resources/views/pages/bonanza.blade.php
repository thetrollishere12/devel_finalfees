@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your Bonanza Paypal fees and shipping with our simple Bonanza spreadsheet & fee calculator. Free Spreadsheet to record all of your sales.
@endsection

@section('title')
Bonanza Paypal Fee Calculator & Spreadsheet
@endsection

@section('content')

<div id="main-calculator">
	<div class="main-container">
    	<h1>BONANZA FEE CALCULATOR</h1>
    	<div class="bonanza-inner">
    		@include('pg_widget.name_date')
			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Select on what type of advertisement you selected.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Advertising</div>
				</div>
				<div>
					<select name="seller_ad">
						<option value=".035">Economy (3.5%)</option>
						<option value=".09">Basic (9%)</option>
						<option value=".19">Superior (19%)</option>
						<option value=".3">Elite (30%)</option>
					</select>
				</div>
			</div>

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
					            <p>Select payment method.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Payment Method</div>
				</div>
				<div>
					<select name="payment-method" id='payment-method'>
						<option disabled>Paypal</option>
						<option value="1">2.9% + 0.30</option>
						<option disabled>Amazon Checkout</option>
						<option>2.9% + $0.30</option>
						<option>2.7% + $0.30</option>
						<option>2.5% + $0.30</option>
						<option>2.2% + $0.30</option>
						<option>1.9% + $0.30</option>
						<option>5% + $0.05</option>
						<option disabled>Google International</option>
						<option>2.9% + $0.30</option>
						<option>2.7% + $0.30</option>
						<option>2.5% + $0.30</option>
						<option>2.2% + $0.30</option>
						<option>1.9% + $0.30</option>
						<option disabled>Other Alternatives</option>
						<option value="other">Money Orders</option>
					</select>
				</div>
			</div>
			@include('pg_widget.tax')
			@include('pg_widget.currency')
			<div class="fee_profit-container">
				<div class="fee_profit-inner"><span><b class="pg-name">Bonanza Fee: </b></span><span id="main-fees">0</span></div>
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
			<h2>ABOUT BONANAZA FEES</h2>
			<p>Bonanza is an affordable online platform very similar to eBay, where you can find and sell a variety of products. Fees are determined based on the final offer value (FOV); the amount you received on your sold item plus any portion on shipping exceeding $10. No matter what amount your FOV is Bonanza's minimum fee is always at least $0.50. Although, for FOV under $500 Bonanza takes 3.5% (or your selected percentage). For FOV over $500 Bonanza takes 3.5% (or your selected percentage) plus 1.5% of the amount over $500.</p>
		</div>
		@include('inc.graph')
	</div>
</div>
		
@endsection

