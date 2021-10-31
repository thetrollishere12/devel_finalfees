@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your Poshmark fees, selling fees and profits with our Poshmark spreadsheet & fee calculator. Free Spreadsheet to record all of your sales.
@endsection

@section('title')
Poshmark Fee Calculator & Spreadsheet - Calculate Poshmark Fees
@endsection

@section('content')

<div id="main-calculator">
	<div class="main-container">
    	<h1>POSHMARK FEE CALCULATOR</h1>
    	<div class="poshmark-inner">
    		@include('pg_widget.name_date')
			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Select the country platform you are selling on.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Country</div>
				</div>
				<div>
					<select name="country">
						<option value="2.95">USA</option>
						<option value="3.95">Canada</option>
					</select>
				</div>
			</div>
			@include('pg_widget.sold')

			@include('pg_widget.cost')

			@include('pg_widget.ship_cost')

			<div class="input-container" style="display:none">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					        	<p>Enter the amount you discounted off your item.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div class="input-container-txt">Discount</div>
				</div>
				<div><input type="number" name="discount_amount"></div>
			</div>

			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Enter the tax percentage you are charged on Poshmark Fees.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Tax on Poshmark Fee</div>
				</div>
				<div class="tax-container">
					<input type="number" id="" oninput="nmb_length(this)" maxlength="6" name="item_tax_fee">
					<div class="symbol">%</div>
				</div>
			</div>

			@include('pg_widget.tax')
			@include('pg_widget.currency')
			<div class="fee_profit-container">

				<div class="fee_profit-inner">
					<span><b class="pg-name">Poshmark Fee: </b></span><span id="main-fees">0</span>
				</div>
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
			<a href="{{ url('auto/ebay')}}"><h2 class="bbb">TRY OUR POSHMARK SALE EXTENSION</h2></a>
			<p>You can now import <span class="bb">hundreds</span> of your sold listings in a <span class="bb">heartbeat</span> with all the <span class="bb">fees & profits</span> without having to do a thing! Now available on <span class="bb">Google Chrome Web Store</span>.
			<br><a href="{{ url('auto/ebay')}}"><button>Click Here To Try It Now</button></a><a href="{{ url('tutorial-autosheet')}}"><button>Click Here For Tutorial</button></a>
			<br>
			</p>
		</div>

		<div class="about-container">
			<h2>ABOUT POSHMARK FEES</h2>
			<p>Poshmark is a online marketplace where users buy and sell fashion. With every item sold a Poshmark selling fee is charged. For all sales under $20 Poshmark takes a flat fee of $2.95 for US & $3.95 for Canada. For all sales over $20, Poshmark takes a commission of 20% of the total sale.</p>
		</div>
		@include('inc.graph')
	</div>
</div>

@endsection


