<div class="import-table">

	<select>

		<option>Ebay - Username</option>

		<option>Ebay - Username</option>

	</select>

	<input type="Date" name="" required>

	<button class="account_select" id="1">Search</button>

</div>
<?php $item_list=$array['ActiveList']['ItemArray']['Item']; ?>
<table class="sold-table">

	<tr>

		<th>Image</th>

		<th>Sale Date</th>

		<th>Name</th>

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
<?php // echo "<pre>";  print_r($item_list); echo "</pre>";
 foreach ($item_list as $key => $item_list_value) {
 	$image_url=$item_list_value['PictureDetails']['GalleryURL'];
 	$image_url_final = ($image_url=='') ? 'https://thumbs.ebaystatic.com/pict/2834071312266464_1.jpg' : $image_url ;
	
 ?>
	<tr>

		<th>

			<input type="image" src="<?php echo $image_url_final; ?>">

		</th>

		<th>

			<input type="text" maxlength="20" name="name" value="123">

		</th>

		<th>

			<input type="number" oninput="nmb_length(this)" maxlength="20" name="sold_price" value="1231">

		</th>

		<th>

			<input type="number" name="item_cost" oninput="nmb_length(this)" maxlength="20" value="123">

		</th>

		<th>

			<input type="number" name="shipping_charge" oninput="nmb_length(this)" maxlength="20" value="321">

		</th>

		<th>

			<input type="number" name="shipping_cost" oninput="nmb_length(this)" maxlength="20" value="123">

		</th>

		<th>

			<input type="number" name="fees" oninput="nmb_length(this)" maxlength="20" value="123">

		</th>

		<th>

			<input type="number" name="other_fees" oninput="nmb_length(this)" maxlength="20" value="1231">

		</th>

		<th>

			<input type="number" name="processing_fees" oninput="nmb_length(this)" maxlength="20" value="123">

		</th>

		<th>

			<input type="number" name="tax" oninput="nmb_length(this)" maxlength="20" value="12312">

		</th>

		<th>

			<input type="number" name="profit" oninput="nmb_length(this)" maxlength="20" value="1232">

		</th>

		<th>

			<input type="number" name="profit" oninput="nmb_length(this)" maxlength="20" value="1232">

		</th>

		<th>

			<button class="sales_edit" id="1">Edit</button>

		</th>

		<th>

			<button class="sales_select" id="1">Select</button>

		</th>

		<input id="sheet_id" type="hidden" value="1">

	</tr>
<?php } ?>
</table>

@if(isset(Auth::user()->email_verified_at))

			<div id="list"></div>

			<div>

				<button class="create_sheet" data-toggle="modal" data-target="#add_page">Create Spreadsheet</button>

			</div>

		@else

			<a href="{{url('/register?create_account')}}"><button class="add_sheet_btn">Add To Spreadsheet</button></a>

		@endif

		<div class="alert alert-dismissible collapse">

		    <button type="button" id="close_alert" class="close">&times;</button>

		    <div class="alert-message"></div>

		 </div>

<style type="text/css">

	

.import-table {

    text-align: left;

    width: 1200px;

}



.import-row{

	display:flex;

	border: solid 1px #eaeaea;

	align-items:center;

	padding: 5px;

	border-radius: 4px;

	margin: 5px;

	transition: .3s;

}



.import-row:hover{

	color: white;

	background: #3490dc;

}



.import-row div{

	width: 100%;

}



.import-row div:last-child{

	text-align: right;

}



.account_select{

	background: rgb(76, 175, 80);

    color: white;

    border: none;

    padding: 3px;

    border-radius: 4px;

    cursor: pointer;

    margin: .5px 1px;

}



.sold-table {

    border-collapse: collapse;

    color: #4c4c4c;

    min-width: 1000px

}



.sold-table input {

    pointer-events: none;

    border: solid 1px #eaeaea;

    width: 100%;

    padding: 3px;

    font-size: 11px;

    height: 28px

}



.sold-table input:focus {

    background: rgba(52, 144, 220, .1);

    outline: none;

    color: #007bff

}



.sold-table tr:nth-child(1) th {

    text-align: left;

    padding: 3px 3px;

    color: white;

    font-weight: 400;

    font-size: 11px

}



.sold-table tr:first-child th:nth-child(1) {

    background: #f46242;

    border: solid 1px #f46242;

}



.sold-table tr:first-child th:nth-child(2) {

    background: rgba(255,123,76,.9);

    border: solid 1px rgba(255,123,76,.9);

}



.sold-table tr:first-child th:nth-child(3) {

    background: rgba(249, 154, 54, .9);

    border: solid 1px rgba(249, 154, 54, .9)

}



.sold-table tr:first-child th:nth-child(4),

tr:first-child th:nth-child(6) {

    background: #3490dc;

    border: solid 1px #3490dc

}



.sold-table tr:first-child th:nth-child(5),

tr:first-child th:nth-child(7) {

    background: rgba(255, 193, 7, .9);

    border: solid 1px rgba(255, 193, 7, .9)

}



.sold-table tr:first-child th:nth-child(8),

tr:first-child th:nth-child(9),

tr:first-child th:nth-child(10),

tr:first-child th:nth-child(11) {

    background: rgba(200, 35, 51, .8);

    border: solid 1px rgba(200, 35, 51, .8)

}



.sold-table tr:first-child th:nth-child(12) {

    background: rgba(76, 175, 80, .8);

    border: solid 1px rgba(76, 175, 80, 1)

}



.sales_select{

	background:rgb(76, 175, 80);

    color: white;

    border: none;

    padding: 3px;

    width: 50px;

    border-radius: 4px;

    cursor: pointer;

    margin: .5px 1px;

}



#sheet_page_list{

	width: 15%;

}



</style>

<script type="text/javascript">

	list();

    function list() {

        $.ajax({

            url: "/pg_sheet_list",

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            },

            method: "POST",

            success: function(result) {

                $("#list").empty().append(result)

            },

            error: function(request, status, error) {

                $("#list").empty().append("Error")

            }

        })

    }

</script>