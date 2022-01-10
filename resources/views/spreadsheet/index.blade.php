@extends('layouts.noapp')

@section('title')
	Your Spreadsheets
@endsection()

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.0"></script>
	<div class="spreadsheet-inner">
		<div class="spreadsheet-list-container">
			<div class="spreadsheet-list">
				<h2 onclick="summary();" id="summary" class="b-click summary-tab sheet">Summary</h2>
				<h2>Your Spreadsheets</h2>
				<ul class="sheet-ul"></ul>
				<div class="create-container">
					<button type="button" class="new_sheet_btn"  data-toggle="modal" data-target="#add_page">Create Spreadsheet</button>
				</div>
			</div>
		</div>
		<div class="spreadsheet-container">
			<div class="load_ctn"><img class="preloader" src="image/preloader.gif"></div>

			<div id="spreadsheet_title">
				<a href="{{url('spreadsheet')}}"><span class="selected-blue">Spreadsheet</span></a>
				<a href="{{url('yearly-breakdown')}}"><span>Monthly Breakdown</span></a>
		<!-- 		<button class="print_btn">Print</button> -->
			</div>

			<div id="spreadsheet_title">
				<span id="title">Summary</span>
				<button id="download_btn">Download</button>
			</div>
			<div class="spreadsheet-summary">
				<div class="summary-case">
					<p>Records</p>
					<div class="spreadsheet-numbers">
						<!-- <select name="currency_name">
							<option value="$">USD</option>
							<option value="C$">CAD</option>
							<option value="€">EUR</option>
							<option value="AED">AED</option>
							<option value="AU$">AUD</option>
							<option value="CN¥">CNY</option>
							<option value="£">GBP</option>
							<option value="HK$">HKD</option>
							<option value="¥">JPY</option>
							<option value="MX$">MXN</option>
							<option value="NZ$">NZD</option>
						</select> -->

						<p>Total Sales: <span id="sum_sales"></span></p>
						<p>Total Sold: <span id="sum_sold"></span></p>
            <p>Total Item Cost: <span id="sum_cost"></span></p>
            <p>Total Shipping Charge: <span id="sum_ship_charge"></span></p>
            <p>Total Shipping Cost: <span id="sum_ship_cost"></span></p>
            <p>Total Fees: <span id="sum_fees"></span></p>
            <p>Total Paypal/Proc Fees: <span id="sum_p_fees"></span></p>
            <p>Total Tax: <span id="sum_tax"></span></p>
            <p>Total Expense: <span id="sum_expense"></span></p>
            <p>Total Profit: <span id="sum_profit"></span></p>
					</div>
				</div>
    			<div class="summary-case">
    				<p>Sale Chart</p>
    				<div>
    					<canvas id="chart"></canvas>
    				</div>
    			</div>

	    			<div class="summary-case">
	    				<p>Bar Chart</p>
	    				@if(user_is_subscribed())
	    				<div>
	    					<canvas id="barchart"></canvas>
	    				</div>
	    				@else
	    				<div class="upgrade-case">
		    				<section>
		    					<p>Bar Chart</p>
		    					<p>Premium Access Only</p>
		    					<p><a href="{{url('/subscription')}}">Sign Up Now</a></p>
		    				</section>
		    				<img src="image/chart3.jpg">
		    			</div>
	    				@endif
	    			</div>
	    			<div class="summary-case">
	    				<p>Year Line Graph</p>
	    				@if(user_is_subscribed())
	    				<div>
	    				
		    				{{ Form::selectYear('year', \Carbon\Carbon::now()->year, 2019) }}
		    				<select name="yearly">
		    					<option value="sold_price">Sold Price</option>
		    					<option value="item_cost">Item Cost</option>
		    					<option value="shipping_charge">Shipping Charge</option>
		    					<option value="shipping_cost">Shipping Cost</option>
		    					<option value="fees">Fees</option>
		    					<option value="other_fees">Other Fees</option>
		    					<option value="processing_fees">Paypal/Processing Fees</option>
		    					<option value="tax">Tax</option>
		    					<option value="total_fees">Total Fees</option>
		    					<option value="expense">Expense</option>
		    					<option value="profit">Profit</option>
<!-- 		    					<option value="profit">Profit</option> -->
		    				</select>
		    				<button class="reset_btn">Reset</button>
		    				<canvas id="line"></canvas>
		    			</div>
	    				@else
	    				<div class="upgrade-case">
		    				<section>
		    					<p>Monthly Line Chart</p>
		    					<p>Premium Access Only</p>
		    					<p><a href="{{url('/subscription')}}">Sign Up Now</a></p>
		    				</section>
		    				<img src="image/chart4.jpg">
		    			</div>
	    				@endif
	    			</div>
			</div>
			<div id="spreadsheet_title">
				<span id="title">Sales</span>
		<!-- 		<button class="print_btn">Print</button> -->
			</div>
			<div class="filter-container">
				<div class="filter-inner">
					<div class="sort-ctn">
					Sort By
						<select name="sort">
							<option value="date">Date</option>
							<option value="name">Name</option>
							<option value="sold_price">Sold Price</option>
							<option value="item_cost">Item Cost</option>
							<option value="shipping_charge">Shipping Charge</option>
							<option value="shipping_cost">Shipping Cost</option>
							<option value="fees">Fees</option>
							<option value="other_fees">Other Fees</option>
							<option value="processing_fees">Paypal/Proc Fees</option>
							<option value="tax">Tax</option>
							<option value="profit">Profit</option>
						</select>
						<select name="sort_order">
							<option value="DESC">Descending</option>
							<option value="ASC">Ascending</option>
						</select>
					</div>
					<div class="search-ctn">
						From <input class="date" type="date" name="start" value="" required>
						To <input class="date" type="date" name="end" value="" required>
						<input type="text" placeholder="Search Name" name="search"><button class="search_btn"><span class="icon-search"></span></button><button class="reset_filter">Reset</button>
					</div>
				</div>
			</div>
			
			<div class="spreadsheet-grid"></div>
			

			<div id="spreadsheet_title">
				<span id="title">Expenses</span>
		<!-- 		<button class="print_btn">Print</button> -->
			</div>
			<div class="expense-grid"></div>

		</div>
	</div>

	@include('pg_widget.add_sheet')
	<div class="modal fade" id="name_edit" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Edit Spreadsheet</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
          <div class="form-group">
            <label for="message-text" class="col-form-label">Enter New Spreadsheet Name:</label>
            <input class="form-control" maxlength="25" type="text" id="spreadsheet_rename"></input>
            <input type="hidden" type="number" name="rename_id">
            <input type="hidden" type="text" name="current_name">
          </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="list_delete">Delete List</button>
	        <button type="button" id="new_sheet_name" class="right-btn">Save</button>
	      </div>
	    </div>
	  </div>
	</div>

	@include('pg_widget.premium')

	<div class="alert popup_status">
		<button type="button" id="close_alert" class="close">&times;</button>
	</div>

<style type="text/css">

	ul button{
		display: block;
	}

	.popup_status{
		position:fixed;top: 80%;left: 50%;transform: translate(-50%, -50%);
    	z-index: 10;
    	display: none;
    	color: white;
	}
	
	
	.th-case {
		display:flex;
		align-items: center;
	}

	.th-case div{
		background:white;
		color: black;
		height: 100%;
		padding:4px 3px;
		border: solid 1px #eaeaea;
		font-weight: normal;
	}

	select[name=currency]{
		pointer-events: none;
		padding: 3px;
		border: solid 1px #eaeaea;
	}



</style>
@endsection