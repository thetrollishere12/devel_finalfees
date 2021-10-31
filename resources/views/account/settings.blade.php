@extends('layouts.noapp')

@section('title')

	Settings

@endsection()

@section('content')

	<div class="status-alert">Thank you so much for subscribing.</div>

	@if (Auth::check())

		<div class="setting-container">

			<table>
				<tr>
					<th>Account Type</th>

					@if(Auth::user()->subscribed('main'))

					<th>
						<p class="premium">Premium</p>
					</th>

					<th></th>

					@else

					<th>

						<p class="regular">Regular</p>

					</th>

					<th>

						<form action="{{url('/payment')}}" method="GET">

							@csrf

							<button class="edit_p_btn upgrade_acc">Upgrade</button>

						</form>

					</th>

					@endif

				</tr>

				<tr>

					<th>Payment Information</th>

					@if($subscription->payment_method == 'Stripe')

					<th><img class="card_img" src="image/{{ strtolower(Auth::user()->card_brand) }}.svg"></th>

					<th><a href="{{url('/editpayment')}}"><button class="edit_p_btn">Edit</button></a></th>

					@elseif($subscription->payment_method == 'Paypal')

					<th><img class="card_img" src="image/paypal.svg"> {{ Auth::user()->paypal_email }}</th>

					<th><a href="{{url('/editpayment')}}"><button class="edit_p_btn">Edit</button></a></th>

					@else

					<th>No Payment Info</th>

					<th></th>

					@endif

				</tr>

				<tr>

					<th>Tax Settings</th>

					<th>

						@if(Auth::user()->tax)

						<input type="number" id="{{ Auth::user()->id }}" name="tax" maxlength="6" oninput="nmb_length(this)" value="{{ Auth::user()->tax }}">%

						@else

						<input type="number" id="{{ Auth::user()->id }}" name="tax" maxlength="6" oninput="nmb_length(this)" value="0">%

						@endif

					</th>

					<th><button class="edit_p_btn tax_btn">Edit</button></th>

				</tr>

				<tr>

					<th>Email Address</th>

					<th>

						{{ Auth::user()->email }}

					</th>

					<th></th>

				</tr>

			</table>



		</div>

	@endif



@endsection