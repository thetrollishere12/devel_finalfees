@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your OfferUp fees, shipping amount and profits with our OfferUp spreadsheet & fee calculator. Free Spreadsheet to record all of your sales.
@endsection()

@section('title')
OfferUp Fee Calculator & Spreadsheet - Calculate OfferUp Fee.
@endsection()

@section('content')

<div id="main-calculator">
	<div class="main-container">
    	<h1>OFFERUP FEE CALCULATOR</h1>
		<div class="offerup-inner">
			@include('pg_widget.name_date')
			@include('pg_widget.local')
			@include('pg_widget.sold')
			@include('pg_widget.ship_charge')
			@include('pg_widget.ship_cost')
			@include('pg_widget.cost')
			@include('pg_widget.tax')
			@include('pg_widget.currency')

			<div class="fee_profit-container">
				<div class="fee_profit-inner"><span><b class="pg-name">OfferUp Fee: </b></span><span id="main-fees">0</span></div>
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
			<h2>ABOUT OFFERUP FEES</h2>
			<p>OfferUp is an online mobile-driven local marketplace which you can sell many items in minutes, OfferUp collects 12.9% or a minimum of $1.99 from the total sale price.</p>
		</div>
		@include('inc.graph')
	</div>
</div>

@endsection
