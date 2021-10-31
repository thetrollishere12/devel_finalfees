@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your Chairish fees, shipping amount and profits with our Chairish spreadsheet & fee calculator. Free spreadsheet to record all of your online sales.
@endsection()

@section('title')
Chairish Fee Calculator & Spreadsheet - Calculate Chairish Sale Fee
@endsection()

@section('content')

<div id="main-calculator">
	<div class="main-container">
    	<h1>CHAIRISH FEE CALCULATOR</h1>
		<div class="main-inner">
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
					        	<p>Select what kind of seller you are.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div class="input-container-txt">Seller Plan</div>
				</div>
				<div>
					<select name="membership">
						<option value="0">Consignor</option>
						<option value="1">Professional</option>
						<option value="1">Elite</option>
					</select>
				</div>
			</div>

			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					        	<p>If your sold product was new/custom made or vintage,antique/pre-owned.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div class="input-container-txt">Product Condition</div>
				</div>
				<div>
					<select name="condition">
						<option value="0">Vintage/Antique/Pre-Owned</option>
						<option value="1">New/Custom Made</option>
					</select>
				</div>
			</div>

			@include('pg_widget.tax')
			@include('pg_widget.currency')

			<div class="fee_profit-container">
				<div class="fee_profit-inner"><span><b class="pg-name">Charish Fee: </b></span><span id="main-fees">0</span></div>
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
			<h2>ABOUT CHAIRISH FEES</h2>
			<p>Chairish is an online marketplace where it allows sellers to sell chic and unique decor, art, decoration and furniture. Commission rate on chairish ranged from 20% - 30% depending on your seller plan and if the sold product is new/custom made or pre-owned/vintage/antique.</p>
		</div>
		@include('inc.graph')
	</div>
</div>

@endsection
