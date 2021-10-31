<div class="import-table">
<?php //print_r($ebay_account); ?>
	<select id="active_select" name="ebay_id">
<?php foreach ($ebay_account as $key => $value) {
	# code...
	$sel="";
	if(isset($select_id))
	{
		if($value->id==$select_id)
		{
			$sel="selected";
		}
	}
	else
	{
		$sel="";
	}
 ?>
		<option <?php echo $sel; ?> value="<?php echo $value->id; ?>">Ebay - <?php echo $value->ebay_email; ?></option>
<?php } ?>
		

	</select>

	<!-- <input type="Date" name="" required>

	<button class="account_select" id="1">Search</button> -->

</div>
<table class="item-table">

	<tr>

		<th>Image</th>

		<th>Name</th>

		<th>Current Price</th>

		<th>Item Cost</th>

		<th>Shipping Type</th>

		<th>Shipping Cost</th>

		<!-- <th></th>

		<th></th> -->

	</tr>
<?php 
//echo "<pre>"; print_r($array); echo "</pre>"; ?>
<?php // echo "<pre>";  print_r($item_list); echo "</pre>";
if( !isset($array['ActiveList'])) 
{
?>
<tr>
	<td colspan="6" align="center">No Results Found</td>
</tr>
<?php
}else
{
	@$item_list=$array['ActiveList']['ItemArray']['Item']; 
	foreach ($item_list as $key => $item_list_value) {
 	@$image_url=$item_list_value['PictureDetails']['GalleryURL'];
 	@$image_url_final = ($image_url=='') ? 'https://thumbs.ebaystatic.com/pict/2834071312266464_1.jpg' : $image_url ;
	 @$item_list_value['ShippingDetails']['ShippingType'];
 ?>
	<tr>

		<th>

			<input type="image" src="<?php echo $image_url_final; ?>">

		</th>

		<th>

			<input type="text" maxlength="20" name="name" value="<?php echo @$item_list_value['Title']; ?>">

		</th>

		<th>

			<input type="number" oninput="nmb_length(this)" maxlength="20" name="sold_price" value="<?php echo @$item_list_value['SellingStatus']['CurrentPrice'] ?>">

		</th>

		<th>

			<input type="number" name="item_cost" oninput="nmb_length(this)" maxlength="20" value="<?php echo @$item_list_value['ListingDetails']['ConvertedBuyItNowPrice'] ?>">

		</th>

		<th>

			<!-- <input type="number" name="shipping_charge" oninput="nmb_length(this)" maxlength="20" value="<?php echo $item_list_value['ShippingDetails']['ShippingType'] ?>"> -->
			<input type="text" name="shipping_charge" oninput="nmb_length(this)" maxlength="20" value="<?php echo @$item_list_value['ShippingDetails']['ShippingType'] ?>">

		</th>

		<th>

			<input type="number" name="shipping_cost" oninput="nmb_length(this)" maxlength="20" value="<?php echo @$item_list_value['ShippingDetails']['ShippingServiceOptions']['ShippingServiceCost'] ?>">

		</th>

		<!-- <th>

			<button class="sales_edit" id="1">Edit</button>

		</th>

		<th>

			<button class="sales_delete" id="1">Delete</button>

		</th> -->

		<input id="sheet_id" type="hidden" value="1">

	</tr>
<?php } 
}
 ?>
</table>

<style type="text/css">



.item-table {

    border-collapse: collapse;

    color: #4c4c4c;

    min-width: 1000px

}



.item-table input {

    pointer-events: none;

    border: solid 1px #eaeaea;

    width: 100%;

    padding: 3px;

    font-size: 11px;

    height: 100%;

}



.item-table input:focus {

    background: rgba(52, 144, 220, .1);

    outline: none;

    color: #007bff

}



.item-table tr:nth-child(1) th {

    text-align: left;

    padding: 3px 3px;

    color: white;

    font-weight: 400;

    font-size: 11px

}



.item-table tr:first-child th:nth-child(1) {

    background: #f46242;

    border: solid 1px #f46242

}



.item-table tr:first-child th:nth-child(2) {

    background: rgba(249, 154, 54, .9);

    border: solid 1px rgba(249, 154, 54, .9)

}



.item-table tr:first-child th:nth-child(3),

tr:first-child th:nth-child(5) {

    background: #3490dc;

    border: solid 1px #3490dc

}



.item-table tr:first-child th:nth-child(4),

tr:first-child th:nth-child(6){

    background: rgba(255, 193, 7, .9);

    border: solid 1px rgba(255, 193, 7, .9)

}



</style>

<script type="text/javascript">
	$('#active_select').change(function(){
var active_select=$('#active_select').val();
			$.ajax({

	            url: "active",

	            headers: {

	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

	            },

	            method: "POST",
	            data: 'active_select='+active_select,
	            success: function(result) {

	            	console.log(result);

	                $(".auto-grid").empty().append(result)

	            },

	            error: function(request, status, error) {

	                $(".auto-grid").empty().append("Error")

	            }

	        });

		});
</script>