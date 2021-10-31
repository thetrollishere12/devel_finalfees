@extends('layouts.noapp')
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

				<a href="{{ URL::to('auto/ebay') }}"><h2 class="summary-tab summary-ebay sheet">Ebay</h2></a>

		 		<h2><a href="{{ URL::to('auto/etsy') }}">Etsy</a></h2> 

				<ul class="sheet-ul"></ul>

			</div>

		</div>

		<div class="auto-container">
			<div id="auto_title">

				<a href="{{ URL::to('auto/ebay') }}"><div id="auto_account">Account</div></a>

				<a href="{{ URL::to('auto/sold-item') }}"><div id="auto_sold">Sold Listing</div></a>

			</div>
			@if($ebay_account)
			<div class="auto-grid"></div>
			@else
			<div class="auto-grid2"></div>
			@endif
		</div>
	</div>
	@include('pg_widget.premium')
	<div class="alert popup_status">
		<button type="button" id="close_alert" class="close">&times;</button>
	</div>
<style type="text/css">
.auto-inner a{color:inherit}ul button{display:block}.popup_status{position:fixed;top:80%;left:50%;transform:translate(-50%,-50%);z-index:10;display:none;color:#fff}.import-table{padding-bottom:5px}.navbar.navbar-light .navbar-nav .nav-item .nav-link{color:#fff!important;-webkit-transition:.35s;transition:.35s}
</style>
<script type="text/javascript">
$("#auto_sold").addClass("select-blue");var active_select="<?php echo @$ebay_account[0]->id ?>";$.ajax({url:"sold",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},method:"POST",data:"active_select="+active_select,success:function(e){$(".auto-grid").empty().append(e),$(".load_ctn").fadeOut()},error:function(e,t,a){$(".auto-grid").empty().append("Error")}});
		if($(".auto-grid2").length){
			$.ajax({
	            url: "account",
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            },
	            method: "POST",
	            success: function(result) {
	                $(".auto-grid2").empty().append(result);
	                $(".load_ctn").fadeOut();
	            },
	            error: function(request, status, error) {
	                $(".auto-grid2").empty().append("Error")
	            }
	        });
		}
</script>
@include('pg_widget.add_sheet')
@endsection
