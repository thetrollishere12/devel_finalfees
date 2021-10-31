@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your LetGo fees, shipping amount and profits with our LetGo spreadsheet & fee calculator. Free Spreadsheet to record all of your sales.
@endsection()

@section('title')
LetGo Fee Calculator & Spreadsheet - Calculate LetGo Fee.
@endsection()

@section('content')

<div id="main-calculator">
	<div class="main-container">
    	<h1>LETGO FEE CALCULATOR</h1>
		<div class="letgo-inner">
			@include('pg_widget.name_date')
			@include('pg_widget.sold')
			@include('pg_widget.ship_charge')
			@include('pg_widget.ship_cost')
			@include('pg_widget.cost')
			@include('pg_widget.tax')
			@include('pg_widget.currency')

			<div class="fee_profit-container">
				<div class="fee_profit-inner"><span><b class="pg-name">LetGo Fee: </b></span><span id="main-fees">0</span></div>
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
			<h2>ABOUT LETGO FEES</h2>
			<p>LetGo is an online mobile-driven marketplace which you can sell many items in minutes locally, LetGo is free and does not collect any type of fee.</p>
		</div>
		@include('inc.graph')
	</div>
</div>

@endsection
