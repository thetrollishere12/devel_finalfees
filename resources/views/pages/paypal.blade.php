@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your Paypal transaction fees, costs and profits with our Paypal spreadsheet & fee calculator. Free Spreadsheet to record all of your sales.
@endsection

@section('title')
Paypal Fee Calculator & spreadsheet - Calculate Paypal Fees
@endsection

@section('content')

<div id="main-calculator">
	<div class="main-container">
    	<h1>PAYPAL FEE CALCULATOR</h1>
    	<div class="paypal-inner">
    		@include('pg_widget.name_date')
			@include('pg_widget.sold')


			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Select Paypal rate.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Paypal Rate</div>
				</div>
				<div>
					<select name="paypal-rate">
						<option disabled>Paypal Domestic</option>
						<option value="1">2.9% + $0.30 (Online Transaction)</option>
						<option>2.7% + $0.30 (In Store Transaction)</option>
						<option>2.2% + $0.30 (Charities or Nonprofit) </option>
						<option>5% + $0.05 (Micropayment) </option>
						<option disabled>Paypal International</option>
						<option>4.4% + $0.30 (Online Transaction)</option>
						<option>4.2% + $0.30 (Store Transaction)</option>
						<option>3.7% + $0.30 (Charities or Nonprofit) </option>
						<option>6.5% + $0.05 (Micropayment) </option>
						<option disabled>Paypal Here Card Reader</option>
						<option>3.5% + $0.15 (PayPal HereTM Manual)</option>
						<option>2.7% + $0.15 (PayPal HereTM Swipe)</option>
						<option disabled>Virtual Terminal</option>
						<option>3.1% + $0.30 (PayPal HereTM Manual)</option>
					</select>
				</div>
			</div>
			@include('pg_widget.tax')
            @include('pg_widget.currency')
			<div class="fee_profit-container">
				<div class="fee_profit-inner"><span><b>Tax: </b></span><span id="main-tax"></span></div>
				<div class="fee_profit-inner">
					<span><b class="pg-name">Paypal Fees: </b></span><span style="" id="p-fees">0</span>
				</div>
				<div class="standard">
					<div class="input-paypal-container fee_profit-inner">
						<div>Paypal Percentage Fee</div>
						<div><input class="standards" disabled type="" name="percent" value="2.9">%</div>
					</div>
					<div class="input-paypal-container fee_profit-inner">
						<div>Paypal Flat Fee</div>
						<div><input class="standards" disabled type="" name="standard" value=".30"></div>
					</div>
				</div>
				<div class="button-container">
					<button class="p-reset" name="p-reset">Reset</button>
					<button class="p-edit" name="p-edit">Edit Fees</button>
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
			<h2>ABOUT PAYPAL FEES</h2>
			<p>Paypal is a company that offers services which allows users to make online transactions, receive payments and money transfers. For majority of all Paypal transactions, you will be charged a Paypal transaction fee at 2.9% + $0.30. Paypal transaction fee may also vary based on location, type of currency and method.</p>
		</div>
		@include('inc.graph')
	</div>
</div>
		
@endsection
