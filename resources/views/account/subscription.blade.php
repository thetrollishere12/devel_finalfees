@extends('layouts.noapp')
@section('title')
	View My Subscription
@endsection()
@section('content')


	@if(session('subscribed'))
	<div class="thanks-alert">Thank you so much for subscribing.</div>
	@endif


	@if(Auth::user()->subscribed('main') && Auth::user()->subscription('main')->onGracePeriod())
		<div class="sub-container">
			<div class="sub_end_name"><b>Subscription End Date</b></div>
			<div class="sub_end_date">Your subscription is scheduled to end on <b>{{ Carbon\Carbon::parse($period_end)->format('F d Y') }}</b></div>
			<div>
				@if($subscription->payment_method=='main_paypal' && $date_ends!='')
				<form action="{{url('/resume_subscription_paypal')}}" class="sub_form" method="POST">
		@csrf
		<input type="hidden" name="sub_id" value="<?php echo Auth::user()->paypal_id; ?>">
		<button class="sub-btn resume_sub" type="submit">Resume Subscription</button>
	</form>
	@else
	<form action="{{url('/resume_subscription')}}" method="POST">
					@csrf
					<button class="sub-btn resume_sub" type="submit">Resume Subscription</button>
				</form>
				@endif
				
			</div>
		</div>
	@endif

@if (Session::has('message'))
<div class="alert alert-dismissible">
    <button type="button" id="close_alert" class="close">&times;</button>
    <div class="alert-message">Email Sent</div>
 </div>
@endif
	

<div class="sub-container">

	<table>
		@if(Auth::user()->subscribed('main'))

			<tr>
				<th>Billing</th>
				<th>
					@if(Auth::user()->subscribed('main') && Auth::user()->subscription('main')->onGracePeriod() == false)
					Next ${{$amount/100}} payment will be charged on {{ Carbon\Carbon::parse($period_end)->format('F d Y') }}
					@elseif(Auth::user()->subscribed('main') && Auth::user()->subscription('main')->onGracePeriod() == true)
					Billing scheduled to end on {{ Carbon\Carbon::parse($period_end)->format('F d') }}
					@else
					No Billing
					@endif
				</th>
				<th></th>
			</tr>
			<tr>
				<th>Valid</th>
				<th>
					@if(isset($period_valid))
					Valid throught {{ Carbon\Carbon::parse($period_valid)->format('F d') }} to {{ Carbon\Carbon::parse($period_end)->format('F d') }}
					@else
					Currently None
					@endif
				</th>
				<th></th>
			</tr>
			<tr>
				<th>Payment Information</th>
				@if($subscription->payment_method == 'Stripe' && isset($user->card_brand) && isset($user->card_last_four))
				<th><img class="card_img" src="image/{{ strtolower($user->card_brand) }}.svg"> ending with {{ $user->card_last_four }}</th>
				<th><a href="{{url('/editpayment')}}"><button class="edit_p_btn">Edit Payment</button></a></th>
				@elseif($subscription->payment_method == 'Paypal' && isset($user->paypal_id) && isset($user->paypal_email))
				<th><img class="card_img" src="image/paypal.svg"> {{ $details->subscriber->email_address }}</th>
				@else
				<th>No Payment Info</th>
				<th></th>
				@endif
			</tr>

		@else

			<tr>
				<th>Billing</th>
				<th>No Billing</th>
				<th></th>
			</tr>
			<tr>
				<th>Valid</th>
				<th>Currently None</th>
				<th></th>
			</tr>
			<tr>
				<th>Payment Information</th>
				<th>No Payment Info</th>
				<th></th>
			</tr>

		@endif
	</table>

</div>
	

<div class="sub-ctn-div">

	<div class=" regular-b @if(Auth::user()->subscribed('main') == false)selected @endif">

	   	<div class="regular-title">Regular</div>
	   	<p class="regular-p"><span class="icon-checkmark"></span> Free/month</p>
		<p class="regular-p"><span class="icon-checkmark"></span> Up To 3 Spreadsheets</p>
		<p class="regular-p"><span class="icon-checkmark"></span> Up To 25 Sales</p>
	</div>

	<div class="premium-b @if(Auth::user()->subscribed('main')) selected-p @endif">
		
		@include('inc.upgrade_acc')

		@if(Auth::user()->subscribed('main'))

			@if(Auth::user()->subscription('main')->onGracePeriod())
			<form action="{{url('/resume_subscription')}}" class="sub_form" method="POST">
				@csrf
				<button class="sub-btn resume_sub" type="submit">Resume Subscription</button>
			</form>
			@endif

			@if(Auth::user()->subscription('main')->onGracePeriod() == false)
			<form action="{{url('/cancel_subscription')}}" class="sub_form" method="POST">
				@csrf
				<button class="sub-btn cancel_sub" type="submit">Cancel Subscription</button>
			</form>
			@endif
		
		@else
				<a href="{{url('/payment')}}"><button class="sub-btn upgrade_sub" type="submit">Upgrade To Premium</button></a>
		@endif	
		
	</div>



</div>

<div class="sub-container">
	<div class="trans-title">What will this help us with?</div>
	<div class="trans-list">- Hiring Developers to create a new etsy import system</div>
	<div class="trans-list">- Hiring Developers to create a new extension to import Depop, Grailed and Poshmark</div>
	<div class="trans-list">- Hiring Designers to visually improve our site</div>

	<div class="suggest-title">Suggest any changes or ideas you would like to see!</div>
	<form method="POST" action="{{ url('/post-suggestion') }}">
		@csrf
		<textarea placeholder="Write Your Suggestion" class="suggestion-textarea" name="textarea"></textarea>
		<button type="submit" class="trans-btn">Submit</button>
		<div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
		@if($errors->any())
            <div><b style="color:#ff3d50!important;">{{$errors->first()}}</b></div>
        @endif
	</form>

</div>


	<style type="text/css">
		
		.trans-title{
			color: #5aa5e2;
			font-size: 19px;
			margin-bottom: 5px;
		}

		.suggest-title{
			color: #5aa5e2;
			font-size: 19px;
			margin-top: 15px;
			margin-bottom:5px;
		}

		.trans-list{
			font-size: 13px;
		}

		.trans-btn{
			border: 1px solid transparent;
		    background: #3490dc;
		    transition: .3s;
		    border-radius: 3px;
		    padding: 4px 12px;
		    cursor: pointer;
		    color: white;
		    margin-bottom: 5px;
		}

		.suggestion-textarea{
			padding: 3px;
			outline: none;
			font-size: 13px;
			width: 100%;
			resize: none;
			height: 100px;
		}

		/*alert*/

#close_alert, .alert {
    padding: 0.5rem 25% !important;
}

.alert {
    background: rgba(76, 175, 80) !important;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    text-align: center;
    color: white !important;
}

#close_alert, .alert {
    padding: 0.5rem 25% !important;
}

.alert-dismissible .close {
    position: absolute;
    top: 0;
    right: 0;
    padding: .50rem 1rem;
    color: inherit;
}



	</style>

@endsection