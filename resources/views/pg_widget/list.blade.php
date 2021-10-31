@if(count($spreadsheet) > 0)
	<div id="list">
		<button type="button" class="add_sales_btn">Add To</button>
		<select id="sheet_page_list" name="selects">
				@foreach($spreadsheet as $ss)
				<option id="{{$ss->spreadsheet_id}}">Spreadsheet: {{$ss->spreadsheet_name}}</option>
				@endforeach
		</select>
	</div>
@endif