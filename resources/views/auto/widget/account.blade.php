<div class="account-table">
	<!-- Example -->
@foreach($ebay_account as $ebay_account_single)
  
  <div class="account-row">

		<div class="account-platform">Ebay</div>

		<div class="account-email">{{ $ebay_account_single->ebay_email }}</div>

		<div class="account-btn">

			<a class="sales_account" href="{{ url('auto/delete_acc_ebay') }}?id={{ $ebay_account_single->id }}" id="{{ $ebay_account_single->id }}">Delete</a>

		</div>

	</div>
@endforeach
	
	<!--  -->

	<div>

		<button class="add_account" class="btn btn-demo" >Connect Account</button>

	</div>

</div>

 <script type="text/javascript">
 	$('.add_account').click(function(){
    $.ajax({

	            url: "ebay_session",

	            headers: {

	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

	            },

	            method: "POST",

	            success: function(result) {

	            	console.log(result);
	            	//result=JSON.parse(result);
	            	var url_windows=result.url_window;
	            	console.log(url_windows);
	               // window.open(url_windows,'_blank', 'toolbar=0,location=0,menubar=0,height=600,width=600');
	               window.location=url_windows;

	            },

	            error: function(request, status, error) {

	               

	            }

	        });
 	})
 </script>