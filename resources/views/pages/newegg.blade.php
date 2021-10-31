@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your Newegg fees, shipping amount and profits with our Newegg spreadsheet & fee calculator. Free spreadsheet to record all of your sales.
@endsection()

@section('title')
Newegg Fee Calculator & Spreadsheet - Calculate Newegg Fee.
@endsection()

@section('content')

<div id="main-calculator">
	<div class="main-container">
    	<h1>NEWEGG MARKETPLACE FEE CALCULATOR</h1>
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
					<div class="input-container-txt">Membership</div>
				</div>
				<div>
					<select name="membership">
						<option value="0">Standard</option>
						<option value="29.95">Professional</option>
						<option value="99.95">Enterprise</option>
					</select>
				</div>
			</div>

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
						<option value="14">Apparel & Accessories</option>
						<option value="12">Appliances</option>
						<option value="13">Arts & Crafts</option>
						<option value="10">Auto & Hardware</option>
						<option value="12">Baby</option>
						<option value="14">Bags & Luggage</option>
						<option value="12">Beauty</option>
						<option value="13">Books, Media & Entertainment</option>
						<option value="9">Camera & Photo</option>
						<option value="13">Cell Phone Accessories</option>
						<option value="8">Cell Phones</option>
						<option value="10">Computer Hardware</option>
						<option value="9">Consumer Electronics</option>
						<option value="10">DVD & Videos</option>
						<option value="15">Food & Beverage</option>
						<option value="12">Health & Personal care</option>
						<option value="12">Home & Living</option>
						<option value="12">Home Improvement</option>
						<option value="10">Motorcycles & Powersports</option>
						<option value="10">Musical Instruments</option>
						<option value="13">Office Supplies</option>
						<option value="12">Outdoor & Garden</option>
						<option value="11">Pet Supplies</option>
						<option value="15">Software</option>
						<option value="12">Sporting Goods</option>
						<option value="12">Toys Games & Hobbies</option>
						<option value="8">Video Game Consoles</option>
						<option value="13">Warranty & Service</option>
						<option value="12">Watches</option>
						<option value="13">Other</option>
					</select>
				</div>
			</div>
			@include('pg_widget.tax')
			@include('pg_widget.currency')

			<div class="fee_profit-container">
				<div class="fee_profit-inner"><span><b class="pg-name">Newegg Fee: </b></span><span id="main-fees">0</span></div>
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
			<h2>ABOUT NEWEGG FEES</h2>
			<p>Newegg is an online marketplace where products like computer hardware and consumer electronics are sold. A commission is charged on each sale made depending on what kind of product category it is and what kind of membership you have chosen.</p>
		</div>
		@include('inc.graph')
	</div>
</div>

@endsection
