@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate & file your eBay fees, eBay store, eBay Paypal fees, profits and listing upgrade fees with our Ebay spreadsheet & fee calculator.
@endsection

@section('title')
eBay Paypal Fee Calculator & Spreadsheet - Calculate eBay Fees
@endsection
		
@section('content')
<div id="main-calculator">
	<div class="main-container">

		<div class="country-container">
			<a href="ebay-us">
				<div>
					<img alt="Calculate & manage your online fees with our USA fee calculator & spreadsheet. Always up to date with the latest United States fees." class="country-icon" src="{{ asset('image/usa4.png?2') }}">
					<figcaption>USA EBAY</figcaption>
				</div>
			</a>
			<a href="ebay-ca">
				<div>
					<img alt="Calculate & manage your online CA fees with our Canada fee calculator & spreadsheet. Always up to date with the latest Canada fees." class="country-icon"  src="{{ asset('image/canada4.png?2') }}">
					<figcaption>CA EBAY</figcaption>
				</div>
			</a>
		</div>
		<div class="whole-calculator">
			<h1>EBAY PAYPAL FEE CALCULATOR</h1>
			<div class="ebay-inner">
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
						            <p>Enter the amount Ebay charged for tax.</p>
								</div>
								<i></i>
							</div>
						</div>
						<div>Ebay Remitted Tax</div>
					</div>
					<div>
						<input type="number" oninput="nmb_length(this)" maxlength="20" name="remitted_tax">
					</div>
				</div>
				@include('pg_widget.tax')
				@include('pg_widget.currency')
				<div class="input-container">
					<div class="label">
						<div class="tooltip">
							<img class="question_img" src="image/question.png" alt="question mark">
							<div class="right">
								<div class="text-content">
						        	<p>Deduction on ebay fee for outstanding seller levels and performance</p>
								</div>
								<i></i>
							</div>
						</div>
						<div class="input-container-txt">Top Rated Seller</div>
					</div>
					<div>
						<select name="t_r_seller">
							<option value="no">No</option>
							<option value="yes">Yes</option>
						</select>
					</div>
				</div>

				<div class="input-container">
					<div class="label">
						<div class="tooltip">
							<img class="question_img" src="image/question.png" alt="question mark">
							<div class="right">
								<div class="text-content">
									<p>Deduction on ebay fee for having an Ebay store(Basic, Premium, and Anchor Stores all charge the same rate).</p>
								</div>
								<i></i>
							</div>
						</div>
						<div class="input-container-txt">Ebay Store</div>
					</div>
					<div>
						<select name="ebay_store">
							<option value="no">No</option>
							<option value="yes">Yes</option>
						</select>
					</div>
				</div>

				<div id="category-slide">
					<div class="input-container">
						<div class="label">
							<div class="tooltip">
								<img class="question_img" src="image/question.png" alt="question mark">
								<div class="right">
									<div class="text-content">
										<p>Pick out what category is your Ebay store. If your category is not listed this means no additional deduction is given. Select Others if not listed.</p>
									</div>
									<i></i>
								</div>
							</div>
							<div class="input-container-txt">Category</div>
						</div>
						<div>
							<select name="category">
								<option value=".915">Others</option>
								<option value=".815">Automotive Tools, Supplies, Parts & Accessories</option>
								<option value="1.2">Books, DVDs & Movies, Music(Except Records Category)</option>
								<option value=".615">Coins & Paper Money and Stamps</option>
								<option value=".4">Computer/Tablets & Networking and Video Game Consoles</option>
								<option value=".615">Consumer Electronics, Cameras and Photos</option>
								<option value=".4">Heavy Equipment and Concession Trailers & Carts</option>
								<option value=".4">Imaging & Aesthetics Equipment and Commercial Printing Presses</option>
								<option value=".715">Musical Instrument & Gear</option>
							</select>
						</div>
					</div>
				</div>

				<div class="input-container">
					<div class="label">
						<div class="tooltip">
							<img class="question_img" src="image/question.png" alt="question mark">
							<div class="right">
								<div class="text-content">
						            <p>Enter the promotion percentage you are charged.</p>
								</div>
								<i></i>
							</div>
						</div>
						<div>Promotion Cost</div>
					</div>
					<div class="tax-container">
						<input type="number" id="" oninput="nmb_length(this)" maxlength="6" name="ad_cost">
						<div class="symbol">%</div>
					</div>
				</div>

				<div class="input-container half-padding">
					<div class="label">
						<div class="tooltip">
							<img class="question_img" src="image/question.png" alt="question mark">
							<div class="right">
								<div class="text-content">
									<p>Upgrades you have selected for your listing.</p>
								</div>
								<i></i>
							</div>
						</div>
						<div class="input-container-txt">Listing Upgrade</div>
					</div>
					<div>
						<select name="show">
							<option value="hide">Hide</option>
							<option value="show">Show</option>
						</select>
					</div>
				</div>
				<div class="list_up_ctn" style="display: none;">
					<label class="container">Free Listing
						<span class="upgrade-cost"></span>
						<input checked class="upgrade-box" type="checkbox" value="0">
						<span class="checkmark"></span>
					</label>
					<label class="container">1 or 3 Day Listing 
						<span class="upgrade-cost double">+ $1.00</span>
						<input class="upgrade-box" type="checkbox" value="1">
						<span class="checkmark"></span>
					</label>
					<label class="container">2 Categories
						<span class="upgrade-cost"> - Doubles all listing uptrade fees</span>
						<input class="upgrade-box" id="upgrade-double" type="checkbox" value="double">
						<span class="checkmark"></span>
					</label>
					<label class="container">Bold
						<span class="upgrade-cost double">+ $2.00</span>
						<input class="upgrade-box" type="checkbox" value="2">
						<span class="checkmark"></span>
					</label>
					<label class="container">Gallery Plus
						<span class="upgrade-cost double">+ $0.35</span>
						<input class="upgrade-box disabled" type="checkbox" value=".35">
						<span class="checkmark"></span>
					</label>
					<label class="container">International Site Visibility
						<span class="upgrade-cost double">+ $0.10</span>
						<input class="upgrade-box" type="checkbox" value=".10">
						<span class="checkmark"></span>
					</label>
					<label class="container">Scheduled Listing
						<span class="upgrade-cost double">+ $0.10</span>
						<input class="upgrade-box" type="checkbox" value=".10">
						<span class="checkmark"></span>
					</label>
					<label class="container">Listing Designer
						<span class="upgrade-cost double">+ $0.10</span>
						<input class="upgrade-box disabled" type="checkbox" value=".10">
						<span class="checkmark"></span>
					</label>
					<label class="container">Subtitle
						<span class="upgrade-cost double">+ $1.00</span>
						<input class="upgrade-box disabled" type="checkbox" value="1">
						<span class="checkmark"></span>
					</label>
					<label class="container">Value Pack
						<span class="upgrade-cost double value">+ $0.65 - Includes Gallery Plus, Scheduled Listing & Subtitle</span>
						<input class="upgrade-box value_number" type="checkbox" value="0.65">
						<span class="checkmark"></span>
					</label>
				</div>
				<div class="fee_profit-container">

					<div class="fee_profit-inner"><span><b class="pg-name">Ebay Fee: </b></span><span id="main-fees">0</span></div>
					<div class="fee_profit-inner"><span><b>Ebay Upgrade Fees: </b></span><span id="other-fees">0</span></div>
					@include('inc.paypal_slide')
					@include('pg_widget.profit')
					@include('pg_widget.add_to_sheet')
					@include('pg_widget.premium')
				</div>
				@include('inc.ad')
			</div>
		</div>
    	
	</div>
	<div class="details-container">
		<div class="about-container">
			<a href="{{ url('auto/ebay')}}"><h2 class="bbb">TRY OUR INSTANT EBAY FEE SYSTEM</h2></a>
			<p>You can now calculate <span class="bb">hundreds</span> of your sold listings in a <span class="bb">heartbeat</span> with all the <span class="bb">eBay & Paypal fees</span> without having to do a thing! All you have to do is connect with your eBay account and that's it.
			<br><a href="{{ url('auto/ebay')}}"><button>Click Here To Try It Now</button></a><a href="{{ url('tutorial-autosheet')}}"><button>Click Here For Tutorial</button></a>
			<br>
			</p>
		</div>
		<div class="about-container about-fees">
			<h2>ABOUT EBAY FEES</h2>
			<p>eBay is an online marketplace where users buy and sell products. eBay has 3 types of fees: Final Value Fee, Insertion Fee and Listing Upgrade Fee. A final value fee is charged when an item is sold where eBay takes 10% of the sold price and shipping charge combined plus <a href="{{url('/paypal')}}">Paypal fees</a>. If you run out of free listings, a $0.30 insertion fee is charged when you list an item. A listing upgrade fee is charged with any additional upgrades to your listing, such as extra categories or bolded titles.</p>
		</div>
		@include('inc.graph')
	</div>
</div>
<style type="text/css">
	.bb{
		color: #5998ff;
	}

	.bbb{
		background:#5998ff !important;
	}

	.about-container button{
		background: #3490dc;
	    border: none;
	    border-radius: 3px;
	    color: #fff;
	    margin: 6px 10px 6px 0px;
	    padding: 8px 24px;
	    cursor: pointer;
	    outline: 0;
	}
</style>
@endsection