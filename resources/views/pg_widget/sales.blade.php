<?php
$path = storage_path() . "/json/currency.json"; // ie: /var/www/laravel/app/storage/json/filename.json

$json = json_decode(file_get_contents($path), true); 

?>
<table>
	<tr>
		<th>Sale Date</th>
		<th>Name</th>
		<th>Currency</th>
		<th>Sold Price</th>
		<th>Item Cost</th>
		<th>Shipping Charge</th>
		<th>Shipping Cost</th>
		<th>Fees</th>
		<th>Other Fees</th>
		<th>Paypal/Proc Fees</th>
		<th>Tax</th>
		<th>Profit</th>
		<th></th>
		<th></th>
	</tr>
	@foreach($limit as $key=>$s)
	<tr>
		<th>
			<input type="date" maxlength="20" required name="date" value="{{$s->sale_date}}">
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
			<div class="th-case">
				<div>{{$s->currency}}</div><input type="number" oninput="nmb_length(this)" maxlength="20" name="sold_price" value="{{$s->sold_price}}">
			</div>
		</th>
		<th>
			<div class="th-case">
				<div>{{$s->currency}}</div><input type="number" name="item_cost" oninput="nmb_length(this)" maxlength="20" value="{{$s->item_cost}}">
			</div>
		</th>
		<th>
			<div class="th-case">
				<div>{{$s->currency}}</div><input type="number" name="shipping_charge" oninput="nmb_length(this)" maxlength="20" value="{{$s->shipping_charge}}">
			</div>
		</th>
		<th>
			<div class="th-case">
				<div>{{$s->currency}}</div><input type="number" name="shipping_cost" oninput="nmb_length(this)" maxlength="20" value="{{$s->shipping_cost}}">
			</div>
		</th>
		<th>
			<div class="th-case">
				<div>{{$s->currency}}</div><input type="number" name="fees" oninput="nmb_length(this)" maxlength="20" value="{{$s->fees}}">
			</div>
		</th>
		<th>
			<div class="th-case">
			<div>{{$s->currency}}</div><input type="number" name="other_fees" oninput="nmb_length(this)" maxlength="20" value="{{$s->other_fees}}">
		</th>
		<th>
			<div class="th-case">
			<div>{{$s->currency}}</div><input type="number" name="processing_fees" oninput="nmb_length(this)" maxlength="20" value="{{$s->processing_fees}}">
		</th>
		<th>
			<div class="th-case">
				<div>{{$s->currency}}</div><input type="number" name="tax" oninput="nmb_length(this)" maxlength="20" value="{{$s->tax}}">
			</div>
		</th>
		<th>
			<div class="th-case">
				<div>{{$s->currency}}</div><div class="profit-case">{{$s->profit}}</div>
			</div>
		</th>
		<th>
			<button class="sales_edit" id="{{$s->id}}">Edit</button>
		</th>
		<th>
			<button class="sales_delete" id="{{$s->id}}">Delete</button>
		</th>
		<input id="sheet_id" type="hidden" value="{{$s->spreadsheet_id}}">
	</tr>
	@endforeach
</table>
@if(Auth::user()->subscribed('main'))
<div class="pagination-ctn">{!! $limit->links() !!}</div>
@endif

<script type="text/javascript">
	$(document).ready(function(){$('select[name=currency]').each(function(){$(this).val($(this).attr('id'));});
	});
</script>