@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your Kijiji marketplace fees, shipping amount and profits with our Kijiji spreadsheet & fee calculator. Free spreadsheet to record all of your sales.
@endsection()

@section('title')
Kijiji Fee Calculator & Spreadsheet - Calculate Kijiji Sales Fee.
@endsection()

@section('content')

<div id="main-calculator">
	<div class="main-container">
    	<h1>KIJIJI FEE CALCULATOR</h1>
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
					            <p>Enter the amount you paid for the ads.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Ad Cost</div>
				</div>
				<div>
					<input type="number" oninput="nmb_length(this)" maxlength="20" name="ad_cost">
				</div>
			</div>

			@include('pg_widget.tax')
			@include('pg_widget.currency')

			<div class="fee_profit-container">
				<div class="fee_profit-inner"><span><b class="pg-name">Kijiji Fee: </b></span><span id="main-fees">0</span></div>
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
			<h2>ABOUT KIJIJI FEES</h2>
			<p>Kijiji is an online platform that allows users to sell, exchange goods or find services locally. For each category Kijiji offers a limit of ads per category. If the limit is exceeded an ad fee will be charged depending on your location.</p>
		</div>
		@include('inc.graph')
	</div>
</div>

@endsection
