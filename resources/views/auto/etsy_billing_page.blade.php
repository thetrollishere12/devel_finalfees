@extends('layouts.noapp')
@section('others')
    <link href="{{asset('css/etsy_sold_item.css?17')}}" rel="stylesheet" type="text/css" />
    
@endsection
@section('title')
Ebay Auto Sold Product Panel
@endsection
@section('content')

<?php
$month = \Carbon\Carbon::now()->format('m');

?>

<div class="load_ctn" id="loader"><img class="preloader" src="{{ asset('image/preloader.gif') }}"></div>
<!-- start : message by ward -->
<div class="msg animate slide-in-down"></div>
<!-- end message by ward -->
	<div class="auto-inner">

		<div class="auto-list-container">

			<div class="auto-list">

				<a href="{{ URL::to('auto/etsy') }}"><h2 class="summary-tab summary-ebay sheet">Etsy</h2></a>

		 		<a href="{{ URL::to('auto/ebay') }}"><h2>Ebay</h2></a> 

				<ul class="sheet-ul"></ul>

			</div>

		</div>

		<div class="auto-container">
			<div id="auto_title">

				<a href="{{ URL::to('auto/etsy') }}"><div id="auto_account">Account</div></a>

				<a href="{{ URL::to('auto/etsy/sold-item') }}"><div id="auto_sold">Sold Listing</div></a>
				
				<a href="{{ URL::to('auto/etsy/billing-fees') }}"><div id="auto_billing">Billing & Fees</div></a>

            </div>
            
            <h3 style="text-align: center;padding:10px 0px;background: #3490dc;color: white;margin: 4px 0px;">Billing & Fees</h3>
            
            <select id="active_account" name="ebay_id" onchange="activeAccounts();">
                @foreach($etsy_account as $account)
                    <option value="{{$account->etsy_shop_id}}">{{$account->etsy_email}} | {{$account->etsy_shop_id}}</option>
                @endforeach
            </select>
            
            <div class="month-select-container">
            
                <select id="active_year" name="active_year" onchange="activeBilling();">
                @for($year=2021; $year >= 2019; $year--)
                    <option value="{{$year}}">{{$year}}</option>
                @endfor
                </select>

                <select id="active_month" name="active_month" onchange="activeBilling();">
                    <option value="01" @if($month == "01") selected @endif>January</option>
                    <option value="02" @if($month == "02") selected @endif>February</option>
                    <option value="03" @if($month == "03") selected @endif>March</option>
                    <option value="04" @if($month == "04") selected @endif>April</option>
                    <option value="05" @if($month == "05") selected @endif>May</option>
                    <option value="06" @if($month == "06") selected @endif>June</option>
                    <option value="07" @if($month == "07") selected @endif>July</option>
                    <option value="08" @if($month == "08") selected @endif>August</option>
                    <option value="09" @if($month == "09") selected @endif>September</option>
                    <option value="10" @if($month == "10") selected @endif>October</option>
                    <option value="11" @if($month == "11") selected @endif>November</option>
                    <option value="12" @if($month == "12") selected @endif>December</option>
                </select>
                
                
            </div>
            
            <div class="auto-grid3 billing-grid"></div>
            
            <!--<div class="auto-grid2"></div>-->
             <span class="green">Don't See Your Item</span>
            <div class="tooltip" id="tooltips">
            <img class="question_img" src="{{url('image/question2.png')}}" alt="question mark">
            <div class="right">
                <div class="text-content">
                    <p>Some of your recently sold products may take 24 hours to appear since it takes time for eBay to update your account.</p>
                </div>
                <i></i>
            </div>
    </div>

    @if(isset(Auth::user()->email_verified_at))
        <div id="list"></div>
        <div>
            <button class="create_sheet" data-toggle="modal" data-target="#add_page">Create Spreadsheet</button>
        </div>
    @endif
        <div class="alert alert-dismissible collapse newsheet-alert">
            <button type="button" id="newsheet_close_alert" class="close">&times;</button>
            <div class="alert-message newsheet-alert-message"></div>
         </div>
         
	@include('pg_widget.premium')
	<div class="alert popup_status">
		<button type="button" id="close_alert" class="close">&times;</button>
	</div>
<style type="text/css">
#active_year,#active_month{padding:4px 10px;outline:none;border:solid 1px rgba(0, 0, 0, 0.25);}#active_account{padding: 4px 10px;border:solid 1px rgba(0, 0, 0, 0.25);}.auto-inner a{color:inherit}ul button{display:block}.popup_status{position:fixed;top:80%;left:50%;transform:translate(-50%,-50%);z-index:10;display:none;color:#fff}.navbar.navbar-light .navbar-nav .nav-item .nav-link{color:#fff!important;-webkit-transition:.35s;transition:.35s}
</style>
@include('pg_widget.add_sheet')
<script src="{{asset('js/etsy_billing_item.js?34234')}}"></script>
@endsection