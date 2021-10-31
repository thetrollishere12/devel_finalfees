@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your Amazon Paypal fees, processing fees, shipping amount and profits with our Amazon spreadsheet & fee calculator.
@endsection

@section('title')
Amazon Fee Calculator & Spreadsheet - Calculate Amazon Fees
@endsection


@section('content')
<div id="main-calculator">
	<div class="main-container">
    	<h1>AMAZON FEE CALCULATOR</h1>
    	<div class="amazon-inner">
		<div class="amazon-input">
			@include('pg_widget.name_date')
			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Select the category type of the sold product(s)</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Product Type</div>
				</div>
				<div>
					<select name="product_type">
						<option value="45">Amazon Device Accessories</option>
						<option value="15">Baby Products(excluding Baby Apparel)</option>
						<option value="15">Books</option>
						<option value="8">Camera and Photo</option>
						<option value="8">Cell Phone Devices</option>
						<option value="8">Consumer Electronics</option>
						<option value="15">DVD</option>
						<option value="">Electronics Accessories</option>
						<option value="15">Furniture & Decor</option>
						<option value="15">Home & Garden(including Pet Supplies)</option>
						<option value="15">Kitchen</option>
						<option value="">Major Appliances</option>
						<option value="15">Music</option>
						<option value="15">Musical Instruments</option>
						<option value="15">Office Products</option>
						<option value="15">Outdoors</option>
						<option value="6">Personal Computers</option>
						<option value="15">Sorfware & Computer/Video Games</option>
						<option value="15">Sports(excluding Sports Collectibles)</option>
						<option value="15">Tools & Home Improvement</option>
						<option value="12">Tools & Home Improvement(Base Equipment Power Tools)</option>
						<option value="15">Toys & Games</option>
						<option value="8">Unlocked Cell Phones</option>
						<option value="15">Video & DVD</option>
						<option value="8">Video Games Consoles</option>
						<option value="15">Everything Else</option>
						<option value="12">3D Printed Products</option>
						<option value="12">Automotive & Powersports</option>
						<option value="10">Automotive & Powersports(Tires & Wheel Products)</option>
						<option value="15">Beauty</option>
						<option value="17">Clothing & Accessories</option>
						<option value="15">Collectible Books</option>
						<option value="15">Collectible Coins</option>
						<option value="20">Entertainment Collectibles</option>
						<option value="20">Fine Art</option>
						<option value="20">Gift Cards</option>
						<option value="15">Grocery & Gourmet Food</option>
						<option value="15">Health & Personal Care (including Personal Care Appliances)</option>
						<option value="12">Industrial & Scientific (including Food Service and Janitorial & Sanitation)</option>
						<option value="20">Jewelry</option>
						<option value="15">Luggage & Travel Accessories</option>
						<option value="">Shoes, Handbags & Sunglasses</option>
						<option value="20">Sports Collectibles</option>
						<option value="">Watches</option>
					</select>
				</div>
			</div>
		
			@include('pg_widget.sold')
			@include('pg_widget.ship_charge')
			@include('pg_widget.ship_cost')
			@include('pg_widget.cost')
			@include('pg_widget.tax')
			@include('pg_widget.currency')
		</div>

		<div class="fee_profit-container">
			<div class="fee_profit-inner"><span><b class="pg-name">Amazon Fee: </b></span><span id="main-fees">0</span></div>
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
			<h2>ABOUT AMAZON FEES</h2>
			<p>Amazon is an online retail marketplace where they sell a large variety of goods, from house items to cloud services. Amazon offers two selling plans: Professional Selling Plan at $39.99 monthly subscription fee plus per-item selling fees vary by category and Individial plan at $0.99 per item sold plus per-item selling fees vary by category. If an item is sold under Amazon's media categories an additional flat $1.80 variable closing fee will be applied.</p>
		</div>
		@include('inc.graph')
	</div>
</div>	
@endsection
