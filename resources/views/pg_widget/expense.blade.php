<?php
$path = storage_path() . "/json/currency.json"; // ie: /var/www/laravel/app/storage/json/filename.json

$json = json_decode(file_get_contents($path), true); 

?>
<table>
	<tr>
		<th>Expense Date</th>
		<th>Name</th>
		<th>Currency</th>
		<th>Account</th>
		<th>Description</th>
		<th>Amount</th>
		<th>Tax</th>
	</tr>
	@foreach($limit as $key=>$s)
	<tr>
		<th>
			<input type="date" maxlength="20" required name="date" value="{{$s->date}}">
		</th>
		<th>
			<input type="text" maxlength="20" name="name" value="{{$s->name}}">
		</th>
		<th>
			<select name="currency" id="{{$s->currency}}">
				@foreach($json as $key => $value)
					<option disabled>Currency</option>
					@foreach($value as $test)
					<option value="{{ $test['symbol'] }}">{{ $test['code'] }}</option>
					@endforeach
				@endforeach
			</select>
		</th>
		<th>
			<select name="account" id="{{$s->account}}">
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
		</th>
		<th>
			<input type="text" maxlength="300" name="description" value="{{$s->description}}">
		</th>

		<th>
			<div class="th-case">
				<div>{{$s->currency}}</div><input type="number" name="amount" oninput="nmb_length(this)" maxlength="20" value="{{$s->amount}}">
			</div>
		</th>

		<th>
			<div class="th-case">
				<div>{{$s->currency}}</div><input type="number" name="tax" oninput="nmb_length(this)" maxlength="20" value="{{$s->tax}}">
			</div>
		</th>

		<th>
			<button class="expense_edit" id="{{$s->id}}">Edit</button>
		</th>
		<th>
			<button class="expense_delete" id="{{$s->id}}">Delete</button>
		</th>
		<input id="sheet_id" type="hidden" value="{{$s->spreadsheet_id}}">
	</tr>
	@endforeach
</table>
@if(Auth::user()->subscribed('main'))
<div class="pagination-ctn">{!! $limit->links() !!}</div>
@endif

<style type="text/css">
	
	.th-case {
		display:flex;
		align-items: center;
	}

	.th-case div{
		background:white;
		color: black;
		height: 100%;
		padding:4px 3px;
		border: solid 1px #eaeaea;
		font-weight: normal;
	}

	input[name=description]{
		width: 600px;
	}

	select[name=currency]{
		pointer-events: none;
		padding: 3px;
		border: solid 1px #eaeaea;
	}

	select[name=account]{
		pointer-events: none;
		padding: 3px;
		border: solid 1px #eaeaea;
	}

</style>

<script type="text/javascript">
	$(document).ready(function(){
		$('select[name=currency]').each(function(){
			$(this).val($(this).attr('id'));
		});

		$('select[name=account]').each(function(){
			$(this).val($(this).attr('id'));
		});
	});
</script>