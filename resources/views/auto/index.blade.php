@extends('layouts.app')


@section('description')
Automatically import your sales pre-calculated into our spreadsheet system.Calculates all of your profit,cost and fees for platforms such as Ebay,Etsy,Amazon & more.
@endsection

@section('title')
Automatic Sales Import Tracker System For Spreadsheet Ebay Etsy.
@endsection()

@section('content')
	<div class="auto-inner">

<!-- 		<div class="auto-list-container">

			<div class="auto-list">

				<a href="{{ URL::to('auto/ebay') }}"><h2 class="summary-tab summary-ebay sheet">Ebay</h2></a>

			</div>

		</div> -->

		
		<div class="auto-container">
			<a href="{{url('/spreadsheet')}}"><img alt="Spreadsheet System For Online Sales" class="auto-img" src="{{url('image/auto.png')}}"></a>
			<div class="container">
				<h3>A NEW WAY OF DOING THINGS</h3>
				<p>Still using <span class="blue">the traditional excel spreadsheets</span> to keep track of all your online sales? Let's be honest you know how much of a <span class="blue">pain it is to use it on the daily and things can get real messy</span>. Introducing our <span class="blue">new automated sales tracker</span> that <span class="blue">automatically</span> calculates all your fees and ready to be entered in our spreadsheet system <span class="blue">without you doing anything! All you have to do is add your seller's account, select what you want to import into our system and that's it!</span></p>
				<b><p>Currently Available For</p>
				<div class="btn-case">
					<a class="blue" href="{{url('/auto/ebay')}}"><button class="ebay-btn">Ebay</button></a>
					<a class="blue" href="{{url('/auto/etsy')}}"><button class="etsy-btn">Etsy</button></a>
				</div>
				<b><p>Coming Soon</p>
					<button class="amazon-btn">Amazon</button>
			</div>
		</div>

	</div>

	@include('pg_widget.premium')



	<div class="alert popup_status">

		<button type="button" id="close_alert" class="close">&times;</button>

	</div>



@endsection