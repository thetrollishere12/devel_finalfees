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
    	<h1>REFUND</h1>
    	<div class="paypal-inner">
    		

    		@if(Auth::check())
			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Select the date of the refund</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Refund Date</div>
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
					            <p>Enter the name for this refund</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Name</div>
				</div>
				<div>
					<input class="{{$page}}" type="name" maxlength="20" name="name">
				</div>
			</div>
			@endif


			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Enter the total amount sold before fees & excluding shipping charges.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Total Refunded</div>
				</div>
				<div>
					<input type="number" oninput="nmb_length(this)" maxlength="20"  name="refund">
				</div>
			</div>


			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Enter the total amount sold before fees & excluding shipping charges.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Rebate Fees</div>
				</div>
				<div>
					<input type="number" oninput="nmb_length(this)" maxlength="20"  name="fees">
				</div>
			</div>

			<div class="input-container">
				<div class="label">
					<div class="tooltip">
						<img class="question_img" src="image/question.png" alt="question mark">
						<div class="right">
							<div class="text-content">
					            <p>Enter the total amount sold before fees & excluding shipping charges.</p>
							</div>
							<i></i>
						</div>
					</div>
					<div>Rebate Tax</div>
				</div>
				<div>
					<input type="number" oninput="nmb_length(this)" maxlength="20"  name="tax">
				</div>
			</div>


            @include('pg_widget.currency')
			<div class="fee_profit-container">
				<div class="button-container">
					<button class="p-reset" name="p-reset">Reset</button>
				</div>
				@include('pg_widget.add_to_sheet')
				@include('pg_widget.premium')
			</div>
			@include('inc.ad')
		</div>
	</div>
	<div class="details-container">
		<div class="about-container">
			<h2>ABOUT PAYPAL FEES</h2>
			<p>Paypal is a company that offers services which allows users to make online transactions, receive payments and money transfers. For majority of all Paypal transactions, you will be charged a Paypal transaction fee at 2.9% + $0.30. Paypal transaction fee may also vary based on location, type of currency and method.</p>
		</div>
		@include('inc.graph')
	</div>
</div>
		
@endsection