@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your StockX Paypal fees, shipping amount and profits with our StockX fee calculator & spreadsheet. Free Spreadsheet to record all of your sales.
@endsection

@section('title')
StockX Paypal Fee Calculator & Spreadsheet
@endsection

@section('content')

<div id="main-calculator">
	<div class="main-container">
    	<h1>STOCKX FEE CALCULATOR</h1>
    	<div class="stockx-inner">
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
					            <p>Deduction on fees based on your seller levels. Your seller levels are determined by your sales performance.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Seller Level</div>
				</div>
				<div>
					<select name="seller_level" id="seller_level">
						<option value=".095">Level 1 (9.5%)</option>
						<option value=".09">Level 2 (9%)</option>
						<option value=".085">Level 3 (8.5%)</option>
						<option value=".08">Level 4 (8%)</option>
					</select>
				</div>
			</div>
			@include('pg_widget.tax')
			@include('pg_widget.currency')
			<div class="fee_profit-container">
				<div class="fee_profit-inner"><span><b>Processing Fee: </b></span><span id="other-fees">0</span></div>
				<div class="fee_profit-inner"><span><b class="pg-name">StockX Fee: </b></span><span id="main-fees">0</span></div>
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
			<h2>ABOUT STOCKX FEES</h2>
			<p>StockX is an online sneaker marketplace where users sell their new or used pair of sneakers. With their unique authentication process this makes StockX stand out for being one of the safest sites to sell sneakers. For each time a transaction is made StockX collects 8% to 9.5% depending on seller's level and a 3% processing fee of the sold price.</p>
		</div>
		@include('inc.graph')
	</div>	
</div>
		
@endsection
