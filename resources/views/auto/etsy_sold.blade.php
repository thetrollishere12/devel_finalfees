@extends('layouts.noapp')
@section('others')
    <link href="{{asset('css/etsy_sold_item.css?22')}}" rel="stylesheet" type="text/css" />
@endsection
@section('title')
Ebay Auto Sold Product Panel
@endsection
@section('content')

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

				<a href="{{ URL::to('auto/sold-item') }}"><div id="auto_sold">Sold Listing</div></a>
				
				<a href="{{ URL::to('auto/etsy/billing-fees') }}"><div id="auto_billing">Billing & Fees</div></a>

            </div>

            <h3 style="text-align: center;padding:10px 0px;background: #3490dc;color: white;margin-top: 4px;">Sales Transactions</h3>
            
            <select id="active_account" name="ebay_id" onchange="activeAccounts();">
                @foreach($etsy_account as $account)
                    <option value="{{$account->etsy_shop_id}}">{{$account->etsy_email}} | {{$account->etsy_shop_id}}</option>
                @endforeach
            </select>
            
			<div class="auto-grid"></div>

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
#active_account{padding: 4px 10px;border:solid 1px rgba(0, 0, 0, 0.25);}.auto-inner a{color:inherit}ul button{display:block}.popup_status{position:fixed;top:80%;left:50%;transform:translate(-50%,-50%);z-index:10;display:none;color:#fff}.navbar.navbar-light .navbar-nav .nav-item .nav-link{color:#fff!important;-webkit-transition:.35s;transition:.35s}
</style>
<script src="{{asset('js/etsy_sold_item.js?34234')}}"></script>
@include('pg_widget.add_sheet')
@endsection
