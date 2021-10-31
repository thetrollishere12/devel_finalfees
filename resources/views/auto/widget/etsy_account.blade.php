<div class="account-table">
@foreach($etsy_account as $account)
  <div class="account-row">

		<div class="account-platform">Etsy</div>

		<div class="account-email">{{ $account->etsy_email }}</div>

		<div class="account-btn">
        <form action="{{ url('auto/delete_acc_etsy') }}" method="POST">
            @csrf
            <input name="acc_id" type="hidden" value="{{$account->id}}"></input>
            <button type="submit" class="sales_account">Delete</button>
        </form>


		</div>

	</div>
@endforeach
	
	<div>

		<a href="/etsy/account/connect" >
            <button class="add_account" class="btn btn-demo" >Connect Account Etsy</button>
        </a>

	</div>

</div>

