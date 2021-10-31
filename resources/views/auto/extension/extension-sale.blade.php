	<h2 class="depop-h2">Depop Sales</h2>
	@if(count($depopsales) > 0)
	<div class="depop-container">
		
		<table>
			<tr>
				<th class="all-input-th"><input type="checkbox" class="option-input radio all-check" data-input="depop-sale" onclick="allcheck('depop-sale');"></th>
				<th class="th-top">Sale Date</th>
				<th class="th-top">Image</th>
				<th class="th-top">Name</th>
				<th class="th-top">Currency</th>
				<th class="th-top">Sold Price</th>
				<th class="th-top">Item Cost</th>
				<th class="th-top">Shipping Charge</th>
				<th class="th-top">Shipping Cost</th>
				<th class="th-top">Fees</th>
				<th class="th-top">Other Fees</th>
				<th class="th-top">Paypal/Proc Fees</th>
				<th class="th-top">Tax</th>
				<th class="th-top">Profit</th>
			</tr>
			@foreach($depopsales as $depopsale)
			<tr>
				<th><input type="checkbox" data-input="depop-sale" data-id="{{ $depopsale->id }}" name="sold[]" class="fee-checkbox option-input radio"></th>
				<th><div class="checkbox-text">{{ $depopsale->sale_date }}</div></th>
				<th class="input-img-th"><img class="input-img" src="{{ $depopsale->img }}"></th>
				<th><div class="checkbox-text checkbox-name">{{ $depopsale->name }}</div></th>
				<th><div class="checkbox-text">{{ $depopsale->currency }}</div></th>
				<th><input class="table-val" type="number" name="sold_price" value="{{ $depopsale->sold_price }}"></th>
				<th><input class="table-input" type="number" name="item_cost" value="0.00"></th>
				<th><input class="table-input" type="number" name="shipping_cost" value="{{ $depopsale->shipping }}"></th>
				<th><input class="table-input" type="number" name="shipping_charge" value="0.00"></th>
				<th><input class="table-val" type="number" name="fees" value="{{ $depopsale->fees }}"></th>
				<th><input class="table-val" type="number" name="other_fees" value="0.00"></th>
				<th><input class="table-val" type="number" name="proc_fees" value="0.00"></th>
				<th><input class="table-val" type="number" name="tax" value="{{ $depopsale->tax }}"></th>
				<th><input class="table-val" type="number" name="total" profit-data="{{ $depopsale->total }}" value="{{ $depopsale->total }}"></th>
				<th><input type="hidden" name="item_id" value="{{ $depopsale->order_id }}"></th>
				<th><input type="hidden" name="platform" value="depop"></th>
				<th><input type="hidden" name="id" value="{{ $depopsale->id }}"></th>
				<th><input type="hidden" name="quantity" value="{{ $depopsale->quantity }}"></th>
			</tr>
			@endforeach
		</table>

	</div>
	@endif
		
	<h2 class="grailed-h2">Grailed Sales</h2>
	@if(count($grailedsales) > 0)
	<div class="grailed-container">
		
		<table>
			<tr>
				<th class="all-input-th"><input type="checkbox" class="option-input radio all-check" data-input="grailed-sale" onclick="allcheck('grailed-sale');"></th>
				<th class="th-top">Sale Date</th>
				<th class="th-top">Image</th>
				<th class="th-top">Name</th>
				<th class="th-top">Currency</th>
				<th class="th-top">Sold Price</th>
				<th class="th-top">Item Cost</th>
				<th class="th-top">Shipping Charge</th>
				<th class="th-top">Shipping Cost</th>
				<th class="th-top">Estimated Fees</th>
				<th class="th-top">Other Fees</th>
				<th class="th-top">Paypal/Proc Fees</th>
				<th class="th-top">Tax</th>
				<th class="th-top">Estimated Profit</th>
			</tr>
			@foreach($grailedsales as $grailedsale)
			<tr>
				<th><input type="checkbox" name="sold[]" data-id="{{ $grailedsale->id }}" data-input="grailed-sale" class="fee-checkbox option-input radio"></th>
				<th><div class="checkbox-text">{{ $grailedsale->sale_date }}</div></th>
				<th class="input-img-th"><img class="input-img" src="{{ $grailedsale->img }}"></th>
				<th><div class="checkbox-text checkbox-name">{{ $grailedsale->name }}</div></th>
				<th><div class="checkbox-text">{{ $grailedsale->currency }}</div></th>
				<th><input class="table-val" type="number" name="sold_price" value="{{ $grailedsale->sold_price }}"></th>
				<th><input class="table-input" type="number" name="item_cost" value="0.00"></th>
				<th><input class="table-input" type="number" name="shipping_charge" value="0.00"></th>
				<th><input class="table-input" type="number" name="shipping_cost" value="{{ $grailedsale->shipping }}"></th>
				<th><input class="table-val" type="number" name="fees" value="{{ number_format($grailedsale->sold_price * 0.09,2) }}"></th>
				<th><input class="table-val" type="number" name="other_fees" value="0.00"></th>
				<th><input class="table-val" type="number" name="proc_fees" value="{{ number_format(($grailedsale->sold_price * 0.029)+.30,2) }}"></th>
				<th><input class="table-val" type="number" name="tax" value="{{ $grailedsale->tax }}"></th>
				<th><input class="table-val" type="number" name="total" value="{{ number_format($grailedsale->total-(($grailedsale->sold_price * 0.029)+.30)-($grailedsale->sold_price * 0.09),2) }}"></th>
				<th><input type="hidden" name="item_id" value="{{ $grailedsale->order_id }}"></th>
				<th><input type="hidden" name="platform" value="grailed"></th>
				<th><input type="hidden" name="id" value="{{ $grailedsale->id }}"></th>
				<th><input type="hidden" name="quantity" value="{{ $grailedsale->quantity }}"></th>
			</tr>
			@endforeach
		</table>

	</div>
	@endif


	<h2 class="poshmark-h2">Poshmark Sales</h2>
	@if(count($poshsales) > 0)
	<div class="poshmark-container">
		<table>
			<tr>
				<th class="all-input-th"><input type="checkbox" data-input="poshmark-sale" class="option-input radio all-check" onclick="allcheck('poshmark-sale');"></th>
				<th class="th-top">Sale Date</th>
				<th class="th-top">Image</th>
				<th class="th-top">Name</th>
				<th class="th-top">Currency</th>
				<th class="th-top">Sold Price</th>
				<th class="th-top">Item Cost</th>
				<th class="th-top">Shipping Charge</th>
				<th class="th-top">Shipping Cost</th>
				<th class="th-top">Fees</th>
				<th class="th-top">Other Fees</th>
				<th class="th-top">Paypal/Proc Fees</th>
				<th class="th-top">Tax</th>
				<th class="th-top">Profit</th>
			</tr>
			@foreach($poshsales as $poshsale)
			<tr>
				<th><input type="checkbox" name="sold[]" data-id="{{ $poshsale->id }}" data-input="poshmark-sale" class="fee-checkbox option-input radio"></th>
				<th><div class="checkbox-text">{{ $poshsale->sale_date }}</div></th>
				<th class="input-img-th"><img class="input-img" src="{{ $poshsale->img }}"></th>
				<th><div class="checkbox-text checkbox-name">{{ $poshsale->name }}</div></th>
				<th><div class="checkbox-text">{{ $poshsale->currency }}</div></th>
				<th><input class="table-val" type="number" name="sold_price" value="{{ $poshsale->sold_price }}"></th>
				<th><input class="table-input" type="number" name="item_cost" value="0.00"></th>
				<th><input class="table-input" type="number" name="shipping_charge" value="0.00"></th>
				<th><input class="table-input" type="number" name="shipping_cost" value="{{ $poshsale->shipping }}"></th>
				<th><input class="table-val" type="number" name="fees" value="{{ $poshsale->fees }}"></th>
				<th><input class="table-val" type="number" name="other_fees" value="0.00"></th>
				<th><input class="table-val" type="number" name="proc_fees" value="0.00"></th>
				<th><input class="table-val" type="number" name="tax" value="{{ $poshsale->tax }}"></th>
				<th><input class="table-val" type="number" name="total" value="{{ $poshsale->total }}"></th>
				<th><input type="hidden" name="item_id" value="{{ $poshsale->order_id }}"></th>
				<th><input type="hidden" name="platform" value="poshmark"></th>
				<th><input type="hidden" name="id" value="{{ $poshsale->id }}"></th>
				<th><input type="hidden" name="quantity" value="{{ $poshsale->quantity }}"></th>
			</tr>
			@endforeach
		</table>


	@endif