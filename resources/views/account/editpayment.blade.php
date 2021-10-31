@extends('layouts.noapp')

@section('title')
  Edit Your Payment Method
@endsection()

@section('content')
<div id="payment-container">
  <p class="edit-title">Edit Payment Method</p>
  <form action="{{url('/paymentchange')}}" method="POST">
    @csrf
  <script
  src="https://checkout.stripe.com/checkout.js" class="stripe-button"
  data-key="pk_live_BnNpUKdaXzMh7nOGKbBoJ8Hl00laacTV7W"
  data-name="finalfees"
  data-panel-label="Update Card Details"
  data-label="Update Card Details"
  data-allow-remember-me=false
  data-locale="auto">
  </script>
</form>
</div>
@endsection