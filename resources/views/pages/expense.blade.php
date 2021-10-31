@extends('layouts.app')

@section('others')
	<script type="text/javascript" src="js/general.js"></script>
	<script type="text/javascript" src="js/countUp.js"></script>
@endsection

@section('description')
Calculate your Paypal transaction fees, costs and profits with our Paypal spreadsheet & fee calculator. Free Spreadsheet to record all of your sales.
@endsection

@section('title')
Paypal Fee Calculator & spreadsheet - Calculate Paypal Fees
@endsection

@section('content')

<div id="main-calculator">
	<div class="main-container">
    	<h1>NEW EXPENSE</h1>
    	<div class="expense-inner">


			@if(Auth::check())
			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Select the date of the expense</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Expense Date</div>
				</div>
				<div>
					<input type="date" value="2019-01-01" required name="date">
				</div>
			</div>

			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Enter the name for this expense</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Name</div>
				</div>
				<div>
					<input class="{{$page}}" type="name" maxlength="100" name="name">
				</div>
			</div>

			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Enter the description for this expense</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Description</div>
				</div>
				<div>
					<textarea class="{{$page}}" type="name" maxlength="300" name="description"></textarea>
				</div>
			</div>

			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Select what kind of expense category</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Account</div>
				</div>
				<div>
					<select name="account">
						<option disabled>Expense</option>
						<option>310 - Cost Of Goods Sold</option>
						<option>400 - Advertising</option>
						<option>404 - Bank Fees</option>
						<option>408 - Cleaning</option>
						<option>412 - Consulting & Accounting</option>
						<option>416 - Depreciation</option>
						<option>420 - Entertainment</option>
						<option>425 - Freight & Courier</option>
						<option>429 - General Expenses</option>
						<option>433 - Insurance</option>
						<option>437 - Interest Expense</option>
						<option>441 - Legal expenses</option>
						<option>445 - Light, Power, Heating</option>
						<option>449 - Motor Vehicle Expenses</option>
						<option>453 - Office Expenses</option>
						<option>461 - Printing & Stationery</option>
						<option>469 - Rent</option>
						<option>473 - Repairs and Maintenance</option>
						<option>477 - Wages and Salaries</option>
						<option>478 - Superannuation</option>
						<option>485 - Subscriptions</option>
						<option>489 - Telephone & Internet</option>
						<option>493 - Travel - National</option>
						<option>494 - Travel - International</option>
						<option>499 - Realised Currency Gains</option>
						<option>505 - Income Tax Expense</option>
					</select>
				</div>
			</div>

			@endif

			@include('pg_widget.tax')

			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Enter the total amount for your expense.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Amount</div>
				</div>
				<div>
					<input type="number" oninput="nmb_length(this)" maxlength="20"  name="expense">
				</div>
			</div>

            @include('pg_widget.currency')
			<div class="fee_profit-container">
				<div class="fee_profit-inner"><span><b class="pg-name">Expense: </b></span><span id="main-fees">0</span></div>
				<div class="fee_profit-inner"><span><b>Tax: </b></span><span id="main-tax"></span></div>
				<div class="button-container">
					<button class="p-reset" name="p-reset">Reset</button>
				</div>

			@if(isset(Auth::user()->email_verified_at))
				<div id="expense-list"></div>
				<div>
					<button class="create_sheet" data-toggle="modal" data-target="#add_page">Create Spreadsheet</button>
				</div>
			@else
				<a href="{{url('/register?create_account')}}"><button class="add_expense_btn">Add To Spreadsheet</button></a>
			@endif
			<a href="/tutorial-spreadsheet"><button class="how_btn">How Does This Work?</button></a>
			<div class="alert alert-dismissible collapse">
			    <button type="button" id="close_alert" class="close">&times;</button>
			    <div class="alert-message"></div>
			 </div>

				@include('pg_widget.premium')
			</div>
			@include('inc.ad')
		</div>
	</div>
	<div class="details-container">
		<div class="about-container">
			<h2>ABOUT EXPENSES</h2>
			<p>Expenses are money incurred in a business to generate positive cashflow and revenue. Expenses can be in forms of actual cash payments, depreciation of an asset or debt.</p>
		</div>
		@include('inc.graph')
	</div>
</div>
		
@endsection