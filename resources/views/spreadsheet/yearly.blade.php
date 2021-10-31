@extends('layouts.noapp')

@section('title')
	Your Spreadsheets
@endsection()

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.0"></script>

<div class="container">
		<div class="spreadsheet-list-container">
			<div class="spreadsheet-list">
				<h2 id="summary" class="b-click summary-tab sheet">Summary</h2>
				<h2>Your Spreadsheets</h2>
				<ul class="sheet-ul"></ul>
				<div class="create-container">
					<button type="button" class="new_sheet_btn"  data-toggle="modal" data-target="#add_page">Create Spreadsheet</button>
				</div>
			</div>
		</div>

		<div class="yearly-breakdown-ctn">

			<!-- <div class="load_ctn"><img class="preloader" src="image/preloader.gif"></div> -->

			<div id="spreadsheet_title">
				<a href="{{url('spreadsheet')}}"><span>Spreadsheet</span></a>
				<a href="{{url('yearly-breakdown')}}"><span class="selected-blue">Monthly Breakdown</span></a>
		<!-- 		<button class="print_btn">Print</button> -->
			</div>
			<div id="spreadsheet_title">
				<span id="title">Summary</span>
		<!-- 		<button class="print_btn">Print</button> -->
			</div>

			<div class="montly-chart">
				<canvas height="300px;" id="barchart"></canvas>
			</div>

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
@endsection