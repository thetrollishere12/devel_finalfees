@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your Rakuten fees, shipping amount and profits with our Rakuten spreadsheet & fee calculator. Free spreadsheet to record all of your sales.
@endsection()

@section('title')
Rakuten Fee Calculator & Spreadsheet - Calculate Rakuten Fee.
@endsection()

@section('content')

<div id="main-calculator">
	<div class="main-container">
    	<h1>RAKUTEN FEE CALCULATOR</h1>
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
					        	<p>Select what category your sold product was under.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div class="input-container-txt">Product Category</div>
				</div>
				<div>
					<select name="category">
						<option value="12">Automotive & Parts</option>
						<option value="15">Bags & Luggage</option>
						<option value="15">Beauty & Personal Care</option>
						<option value="15">Clothing, Shoes & Accessories</option>
						<option value="15">Clothing, Shoes & Accessories > Fashion Accessories</option>
						<option value="15">Clothing, Shoes & Accessories > Jewelry & Watches</option>
						<option value="15">Clothing, Shoes & Accessories > Shoes</option>
						<option value="8">Electronics</option>
						<option value="8">Electronics > Computers</option>
						<option value="10">Electronics > Software</option>
						<option value="10">Electronics > Video Games</option>
						<option value="15">Food & Beverage</option>
						<option value="15">Health</option>
						<option value="15">Home & Outdoor</option>
						<option value="10">Home & Outdoor > Appliances</option>
						<option value="15">Home & Outdoor > Hobbies</option>
						<option value="12">Home & Outdoor > Hobbies > Musical Instruments</option>
						<option value="15">Media</option>
						<option value="15">Media > Movies & TV</option>
						<option value="15">Media > Music</option>
						<option value="12">Office Supplies</option>
						<option value="15">Pet Supplies</option>
						<option value="15">Sports & Fitness</option>
						<option value="12">Toys, Toddlers & Baby</option>
						<option value="15">Warranties</option>
						<option value="15">Everything Else</option>
					</select>
				</div>
			</div>

			@include('pg_widget.tax')
			@include('pg_widget.currency')

			<div class="fee_profit-container">
				<div class="fee_profit-inner"><span><b class="pg-name">Rakuten Fee: </b></span><span id="main-fees">0</span></div>
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
			<h2>ABOUT RAKUTEN FEES</h2>
			<p>Rakuten is an online marketplace where sellers sell a large variety of goods, from house items to cloud services. For each sale made a 99 cent per item sold fee is applied including a category fee depending on what the product is ranging from 8% - 15%. A $39 monthly fee is also applied.</p>
		</div>
		@include('inc.graph')
	</div>
</div>

@endsection
