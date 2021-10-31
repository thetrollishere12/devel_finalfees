@extends('layouts.app')

@section('description')
Calculate & manage your online fees with our fee calculator, import sales system & spreadsheet system. Automatically calculates all of your profits,cost and fees.
@endsection()

@section('title')
Online Spreadsheet Tracker & Fee Calculator For Your Online Sales
@endsection()

@section('content')

	@if (Session::has('message'))
	<div class="alert alert-dismissible">
	    <button type="button" id="close_alert" class="close">&times;</button>
	    <div class="alert-message">Email Sent</div>
	 </div>
	@endif
	<div class="about">
		<h1>TRACKING & CALCULATING THE RIGHT WAY</h1>
			<div class="about-container">
			@if(!Auth::user())
    			<a href="{{url('/spreadsheet')}}"><img alt="Spreadsheet System For Online Sales" class="spreadsheet-img" src="image/spreadsheet.png"></a>
				<!--<div class="login-container">-->
				<!--	<h3 class="user-o">Try it Free, Our Spreadsheet System</h3>-->
				<!--	<div class="register-form">-->
				<!--	    <form method="POST" action="{{ route('register') }}">-->
				<!--	        @csrf-->
				<!--	        <a href="{{ url('/google-login') }}" class="google_ctn"><img class="google_sign_in" src="{{ asset('image/g_login.png') }}"> Sign Up With Google</a>-->
    <!--    					<div class="or">or</div>-->
    <!--    					<div>-->
				<!--		        <div>-->
				<!--		            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>-->
				<!--		            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>-->
				<!--		        </div>-->
				<!--		        @if ($errors->has('name'))-->
				<!--		            <span class="invalid-feedback" role="alert">-->
				<!--		                <strong>{{ $errors->first('name') }}</strong>-->
				<!--		            </span>-->
				<!--		        @endif-->
				<!--		        <div>-->
				<!--		            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>-->
				<!--		            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>-->
				<!--		        </div>-->
				<!--		        @if ($errors->has('email'))-->
				<!--		            <span class="invalid-feedback" role="alert">-->
				<!--		                <strong>{{ $errors->first('email') }}</strong>-->
				<!--		            </span>-->
				<!--		        @endif-->
				<!--		        <div>-->
				<!--		            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>-->
				<!--		            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>-->
				<!--		        </div>-->
				<!--		        @if ($errors->has('password'))-->
				<!--		            <span class="invalid-feedback" role="alert">-->
				<!--		                <strong>{{ $errors->first('password') }}</strong>-->
				<!--		            </span>-->
				<!--		        @endif-->
				<!--		        <div>-->
				<!--		            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>-->
				<!--		            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>-->
				<!--		        </div>-->
				<!--		        <button type="submit" class="register-btn">-->
				<!--		            {{ __('Sign Up For Free') }}-->
				<!--		        </button>-->
				<!--	    	</div>-->
				<!--	    </form>-->
				<!--	    <div>Already Have An Account?</div>-->
				<!--	    <a href="{{url('/login')}}"><button class="log-btn">Log In Now</button></a>-->
				<!--	</div>-->
				<!--</div>-->
			@elseif(Auth::user())

				@if(Auth::user()->subscribed('main'))
				<a href="{{url('/spreadsheet')}}"><img alt="Spreadsheet System For Online Sales" class="spreadsheet-img" src="image/spreadsheet.png"></a>
				@else
				
				<div class="login-container">
					<h3 class="user-b">Upgrade Your Account</h3>
					<div class="premium-b">
						@include('inc.upgrade_acc')
						<form action="{{url('/payment')}}" class="sub_form" method="GET">
							@csrf
							<button class="sub-btn upgrade_sub" type="submit">Upgrade To Premium</button>
						</form>
					</div>
				</div>
				@endif
			@endif
				<div class="text-container">

					<h3>Keep Track of Your Sales</h3>
					<p>Introducing our <span class="blue">Spreadsheet System</span> utilized for <span class="blue">online sales</span>, available for <span class="blue">all marketplaces and platforms</span>. FinalFees offers efficiency and adaptability with the ability to enter your own numerical values. Our website is dedicated to help calculate and record your fees, shipping costs, and profit. The Spreadsheet System is recommended for competitive, genuine sellers who are active on Ebay, Etsy, Poshmark, Goat, Grailed, Depop, StockX and other similar sites.</p>
					<div class="btn-case-left">
						<a class="blue" href="{{url('/spreadsheet')}}"><button class="blue-btn">Try Spreadsheet Now</button></a>
						<a class="blue" href="{{url('/tutorial-spreadsheet')}}"><button class="blue-btn">Tutorial</button></a>
					</div>
				</div>
			</div>
	</div>



	<div class="about auto">
		<h2>SALES IMPORT EXTENSION</h2>
		<div class="auto-container">
			<a href="https://chrome.google.com/webstore/detail/finalfees-tracker/ckfckhenbpkfpoagigiddcdnofklbpge?hl=en"><img alt="Spreadsheet System For Online Sales" class="auto-img" src="image/extension.jpg"></a>
			<div class="auto-container">
				<h3>A NEW WAY OF IMPORTING YOUR SALES</h3>
				<p>
				Introducing our <span class="blue">new web extension</span>, you can now automatically import your sales from platforms such as <span class="blue">Depop, Grailed and Poshmark</span> with a single click. Our extension will <span class="blue">extract</span> all your <span class="blue">sales fees</span> and <span class="blue">calculate</span> your <span class="blue">profits</span> with ease. Now available on <span class="blue">Google Chrome Web Store.</span>
				</p>
				<div class="btn-case">
					<a class="blue" href="https://chrome.google.com/webstore/detail/finalfees-tracker/ckfckhenbpkfpoagigiddcdnofklbpge?hl=en"><button class="blue-btn">Try Now</button></a>
		<!-- 			<a class="blue" href="{{url('/tutorial-autosheet')}}"><button class="blue-btn">Tutorial</button></a> -->
				</div>
			</div>
		</div>
	</div>



	<div class="about auto">
		<h2>TRY OUR AUTOMATED TRACKER SYSTEM</h2>
		<div class="auto-container">
			<a href="{{url('/spreadsheet')}}"><img alt="Spreadsheet System For Online Sales" class="auto-img" src="image/auto.png"></a>
			<div class="auto-container">
				<h3>FORGET ABOUT USING EXCEL SPREADSHEETS</h3>
				<p>Still using <span class="blue">excel spreadsheets</span> to keep track of everything? Let's be honest you know how much of a <span class="blue">pain it is to use it</span>. Introducing our <span class="blue">new automated sales tracker</span> that <span class="blue">automatically</span> calculates all your fees and ready to be entered in our spreadsheet system <span class="blue">without you doing anything!</span></p>
				<div class="btn-case">
					<a class="blue" href="{{url('/auto')}}"><button class="blue-btn">Try Now</button></a>
					<a class="blue" href="{{url('/tutorial-autosheet')}}"><button class="blue-btn">Tutorial</button></a>
				</div>
			</div>
		</div>
	</div>


	<div>
		<h2>SELECT A PLATFORM</h2>
		@include('inc.company')
		<div class="outer-ad">
			@include('inc.ad')
		</div>
	</div>
@endsection