@extends('layouts.noapp')
@section('title')
  Payment
@endsection()
@section('content')
  @if(Auth::user()->subscribed('main') == false)
  <div id="payment-container">
    <div class="payment-container">
      <div class="premium-b selected-p">
        @include('inc.upgrade_acc')
      </div>
      <p class="privacy-title">Privacy</p>
      <div class="consent-container">
        <div class="consent-inner">
        <label class="container">I consent to the <a href="{{url('/policy-terms')}}">Terms of services</a>
<!--           <input name="terms" required type="checkbox" >
          <span class="checkmark"></span> -->
        </label>
      </div>
      <div class="consent-inner">
        <label class="container">I consent to the <a href="{{url('policy-data')}}">Data Privacy Policy</a>
<!--           <input name="data" required type="checkbox" >
          <span class="checkmark"></span> -->
        </label>
      </div>
      </div>
        <div class="payment_btn_ctn">
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" id="paypal_payment-form">
            @csrf
            <input type="hidden" name="cmd" value="_xclick-subscriptions">
            <input type="hidden" name="business" value="finalfees@gmail.com">
            <input type="hidden" name="lc" value="US">
            <input type="hidden" name="item_name" value="Premium Subscription">
            <input type="hidden" name="no_note" value="1">
            <input type="hidden" name="no_shipping" value="2">
            <input type="hidden" name="src" value="1">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHosted">
            <input type="hidden" name="rm" value="2"> 
            <input type="hidden" name="os0" value="Premium Monthly Subscription">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="option_select0" value="Premium Monthly Subscription">
            <input type="hidden" name="option_amount0" value="3.99">
            <input type="hidden" name="option_period0" value="M">
            <input type="hidden" name="option_frequency0" value="1">
            <input type="hidden" name="option_index" value="0">
            <input type = "hidden" name = "cancel_return" value = "{{url('/')}}">
            <button type="submit" class="stripe-button-el paypal_btn" style="visibility: visible;"><span style="display: block; min-height: 30px;">Paypal</span></button>
        </form>
          <form action="{{url('/payment')}}" method="POST" id="payment-form">
            @csrf
            <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="pk_live_BnNpUKdaXzMh7nOGKbBoJ8Hl00laacTV7W"
            data-amount="399"
            data-name="Finalfees"
            data-description="Premium Subscription"
            data-locale="auto"
            data-email="{{ Auth::user()->email }}"
            data-currency="USD">
            </script>
            <img class="payment-img" src="image/MasterCard.png">
            <img class="payment-img" src="image/Visa.png">
            <img class="payment-img" src="image/American Express.png">
            <img class="payment-img" src="image/ssl.png">
          </form>
          <p>By Paying, you agree to our <a href="{{url('/policy-terms')}}">Terms of service</a> & <a href="{{url('policy-data')}}">Privacy Policy</a> and certify that the information you provided is complete and correct.</p>
        </div>
    </div>
  </div>
  @endif

@endsection





