@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your Mercari fees, processing fees and profits with our Mercari spreadsheet & fee calculator. Free Spreadsheet to record all of your sales.
@endsection

@section('title')
Mercari Fee Calculator & Spreadsheet - Calculate Your Mercari fees
@endsection

@section('content')

<div id="main-calculator">
	<div class="main-container">
    	<h1>MERCARI FEE CALCULATOR</h1>
    	<div class="mercari-inner">
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
					        	<p>To withdraw cash from your Mercari account into your bank.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div class="input-container-txt">Direct Deposit</div>
				</div>
				<div>
					<select name="direct_deposit">
						<option value="no">No</option>
						<option value="yes">Yes</option>
					</select>
				</div>
			</div>
			@include('pg_widget.tax')
			@include('pg_widget.currency')
			<div class="fee_profit-container">
				<div class="fee_profit-inner"><span><b>Processing Fee: </b></span><span id="other-fees">0</span></div>
				<div class="fee_profit-inner"><span><b class="pg-name">Mercari Fee: </b></span><span id="main-fees">0</span></div>
				<div class="fee_profit-inner"><span><b>Tax: </b></span><span id="main-tax"></span></div>
				@include('inc.processing_slide')
				@include('pg_widget.profit')
				@include('pg_widget.add_to_sheet')
				@include('pg_widget.premium')
			</div>
			@include('inc.ad')
		</div>
	</div>
	<div class="details-container">
		<div class="about-container">
			<h2>ABOUT @yield('h2') FEES</h2>
			<p>Mercari is an online platform where you can sell and buy anything. For each time a transaction is made, Mercari collects 10% of the total sold price plus a 2.9% + $0.30 processing fee. If you direct deposit earnings under $10 to your bank, a $2 processing fee may apply.</p>
		</div>
		@include('inc.graph')
	</div>
</div>
		
@endsection

