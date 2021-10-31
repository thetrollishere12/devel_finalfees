@extends('layouts.payment')
@section('title')
  Payment
@endsection()
@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('css/billing.css?'.time().'') }}" rel="stylesheet">
<script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_CLIENT_ID')}}&vault=true&intent=subscription"></script>
<script src="https://js.stripe.com/v3/"></script>

	<main>
		
		<div class="shopping-cart-section">
			
			<div>
			<div style="padding: 10px;" class="icon-circle"><img src="{{asset('image/favicon.png')}}"></div>
			</div>

			<div class="full-cart-price">
				<h2>CA$ {{env('FINALFEE_MONTHLY')}}</h2>
			</div>

			<div class="shopping-cart-container">
				

	
				<div class="summary-tab">
					<div class="slidedown"><span class="icon-cart"></span> Show Order</div>
				</div>

				<div class="cart-product-container">
	  	

				  		<div class="item-container">
				  			<div class="item-container-inner">
								<div class="item-img-container">
									<img src="{{asset('image/check.svg')}}">
								</div>
								<div class="item-img-description">
									<div>Finalfees Monthly Subscription</div>
									<div class="dropdown-name">CA$ {{env('FINALFEE_MONTHLY')}}/Month</div>
									<div></div>
								</div>
							</div>
							<div class="item-price">
								<div><b>CA$ {{env('FINALFEE_MONTHLY')}}</b></div>
							</div>
						</div>

	        	</div>

	            <div class="final_total subtotal_total"><div>Subtotal</div><div class="number-right tax-cost">CA$ {{env('FINALFEE_MONTHLY')}}</div></div>


	            <div class="final_total total_due_total"><div>Total Due</div> <div class="number-right total-cost">CA$ {{env('FINALFEE_MONTHLY')}}</div></div>


			</div>


			<div class="term-service-container">
				<a href="{{ url('policy-terms') }}">Terms</a>
				<a href="{{ url('policy-data') }}">Privacy</a>
			</div>


		</div>



		<div class="payment-section">





		<div><b>Payment Method</b></div>

			<div class="payment-btn-ctn">
				
				<div class="card-btn">
					<img src="{{asset('image/card.svg')}}">
					<span class="card-span">Card</span>
				</div>


				<div id="paypal-button-container"></div>

<!-- 
				<form action="payment-paypal" class="paypal-form" method="POST">
				{{ csrf_field() }}
				<button type="submit" id="paypal" name="paypal" data-name="paypal">
					<img src="{{asset('storage/image/icons/paypal.svg')}}">
				</button>
				</form> -->


			</div>			
	
			<form action="stripe-payment" method="POST" id="paymentFrm">
			@csrf

 			<div class="card-info-b"><b>Card Information</b></div>
 			<div id="paymentResponse"></div>
            <div class="credit-card-container">

            	<div class="form-group card-number-container">
                	<div id="card_number" class="field"></div>
                	<div class="card-img-container">
                		<img src="{{asset('image/visa.svg')}}">
                		<img src="{{asset('image/mastercard.svg')}}">
                		<img src="{{asset('image/ae.svg')}}">
                	</div>
            	</div>
            	
                <div class="card-container-ex-cvc">
                

	            	<div class="form-group expiry-date-container">
	                    <div id="card_expiry" class="field"></div>
	                </div>

	            	<div class="form-group cvc-container">
	                    <div id="card_cvc" class="field"></div>
	                </div>


                </div>

            </div>


  			<button type="submit" class="submit-payment-btn" id="payBtn">Pay CA${{env('FINALFEE_MONTHLY')}}</button>


				</form>	


		</div>



	</main>
<style type="text/css">
	
@import url('https://fonts.googleapis.com/css?family=Open + Sans&display=swap');*{font-family:"Open Sans",sans-serif;-ms-box-sizing:content-box;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box}@media only screen and (min-width:0px){main{grid-template-rows:1fr 1fr;grid-template-columns:1fr}.payment-section{padding:30px}.shopping-cart-section{padding:30px}.cart-product-container{display:none}.summary-tab{display:block}.final_total{margin-left:0}}@media only screen and (min-width:1000px){main{grid-template-rows:1fr;grid-template-columns:1fr 1fr}.payment-section{padding:80px 20px 80px 80px}.shopping-cart-section{padding:80px}.cart-product-container{display:block}.summary-tab{display:none}.summary-tab{width:100%;margin-bottom:5px}.summary-tab div{background:#fff;padding:10px 0;text-align:center;color:#d60d8c;cursor:pointer;transition:.3s;border-radius:8px}.summary-tab div:hover{background:#d60d8c!important;color:#fff}.slidedown{background:#d60d8c!important;transition:.3s;color:#fff!important}body{margin:auto;color:rgba(26,26,26,.7)}main{display:grid;height:101vh;max-width:1100px;margin:auto}main h2{display:none}.shopping-cart-container{display:none}.item-container{display:grid;grid-template-columns:70% 30%}.item-container-inner{display:flex;align-items:center}.item-img-container img{width:25px;padding:0 7px 0 0}img{vertical-align:middle;border-style:none}.item-img-description{font-size:12px;font-weight:700}.item-price{display:flex;align-items:center;justify-content:flex-end}.payment-section{box-shadow:-6px 0 16px -9px rgb(0 0 0 / 10%)}.submit-payment-btn{background-color:#3490dc;color:#fff}#payment-form form{width:30vw;min-width:500px;align-self:center;box-shadow:0 0 0 .5px rgba(50,50,93,.1),0 2px 5px 0 rgba(50,50,93,.1),0 1px 1.5px 0 rgba(0,0,0,.07);border-radius:7px;padding:40px}#payment-form input{border-radius:6px;margin-bottom:6px;padding:12px;border:1px solid rgba(50,50,93,.1);height:44px;font-size:16px;width:100%;background:#fff}#payment-form .result-message{line-height:22px;font-size:16px}#payment-form .result-message a{color:#596fd6;font-weight:600;text-decoration:none}#payment-form .hidden{display:none}#payment-form #card-error{color:#697386;text-align:left;font-size:13px;line-height:17px;margin-top:12px}#payment-form #card-element{border-radius:4px 4px 0 0;padding:12px;border:1px solid rgba(50,50,93,.1);height:44px;width:100%;background:#fff}#payment-form #payment-request-button{margin-bottom:32px}#payment-form button{background:#5469d4;color:#fff;font-family:Arial,sans-serif;border-radius:0 0 4px 4px;border:0;padding:12px 16px;font-size:16px;font-weight:600;cursor:pointer;display:block;transition:all .2s ease;box-shadow:0 4px 5.5px 0 rgba(0,0,0,.07);width:100%}#payment-form button:hover{filter:contrast(115%)}#payment-form button:disabled{opacity:.5;cursor:default}.spinner,.spinner:after,.spinner:before{border-radius:50%}.spinner{color:#fff;font-size:22px;text-indent:-99999px;margin:0 auto;position:relative;width:20px;height:20px;box-shadow:inset 0 0 0 2px;-webkit-transform:translateZ(0);-ms-transform:translateZ(0);transform:translateZ(0)}.spinner:after,.spinner:before{position:absolute;content:""}.spinner:before{width:10.4px;height:20.4px;background:#5469d4;border-radius:20.4px 0 0 20.4px;top:-.2px;left:-.2px;-webkit-transform-origin:10.4px 10.2px;transform-origin:10.4px 10.2px;-webkit-animation:loading 2s infinite ease 1.5s;animation:loading 2s infinite ease 1.5s}.spinner:after{width:10.4px;height:10.2px;background:#5469d4;border-radius:0 10.2px 10.2px 0;top:-.1px;left:10.2px;-webkit-transform-origin:0 10.2px;transform-origin:0 10.2px;-webkit-animation:loading 2s infinite ease;animation:loading 2s infinite ease}.icon-circle{border-radius:400px;border:1px solid rgba(26,26,26,.1);width:40px;margin-bottom:20px}.icon-circle img{width:100%}.full-cart-price h2{margin-top:0;font-size:40px;color:rgba(26,26,26,.9)}.term-service-container{text-align:right;margin-top:100px}.term-service-container a{text-decoration:none;color:rgba(26,26,26,.5);font-size:13px;padding-left:15px}.subtotal_total{border-bottom:1px solid rgba(26,26,26,.1);padding:17px 0;font-weight:700}.shipping_total{padding:17px 0;color:rgba(26,26,26,.5)}.tax_total{padding-bottom:17px;border-bottom:1px solid rgba(26,26,26,.1);color:rgba(26,26,26,.5)}.total_due_total{font-weight:700;padding-top:17px}.final_total{display:flex;font-size:14px}.final_total div{width:100%}.final_total .number-right{text-align:right}.email-information{margin-top:15px;border:1px solid rgba(26,26,26,.1);border-radius:6px;background-color:#fefbe7;font-size:13px;color:rgba(26,26,26,.6);margin-bottom:15px}.email-information div{padding:8px 12px 8px 12px;border-bottom:1px solid rgba(26,26,26,.1)}.phone-number-div{border-bottom:none!important}.email-information b{padding-right:5px}.shipping-address-container{border:1px solid rgba(26,26,26,.1);border-radius:6px;background-color:#fefbe7;font-size:13px;margin:15px 0}.shipping-address-line1{padding:8px 12px;border-bottom:1px solid rgba(26,26,26,.1)}.shipping-address-line2{padding:8px 12px;border-bottom:1px solid rgba(26,26,26,.1)}.shipping-address-line3{padding:8px 12px}#paymentResponse{color:#f53333;margin-bottom:-7px;font-size:14px}#paymentResponse p{margin:8px 0 13px 0}.card-info-b{margin-bottom:15px}.billing-checkbox-ctn b{position:relative;top:-2px}.billing-address-container{display:none}.billing-address-container input[name=billing-name]{width:94%;padding:8px 12px;border:1px solid rgba(26,26,26,.1);border-radius:6px;outline:0;margin:15px 0}.billing-info{border-radius:6px;margin:15px 0 30px 0}.billing-info input,.billing-info select{display:block;width:94%;padding:8px 12px;border:1px solid rgba(26,26,26,.1);outline:0}.billing-info input{text-indent:5px}select[name=billing_country]{border-top-right-radius:6px;border-top-left-radius:6px;border-bottom:none}input[name=billing_address_line_2]{border-bottom:none;border-top:none}select[name=billing_s_p_r]{border-bottom:none;border-top:none}input[name=billing_postal_zipcode]{border-bottom-right-radius:6px;border-bottom-left-radius:6px}.card-number-container{position:relative}.card-img-container{display:inline-block;position:absolute;top:10px;right:10px}.billing-checkbox-ctn{margin:20px 0 30px 0}.billing-address{font-size:13px}.payment-btn-ctn{display:flex;margin:15px 0}.paypal-form{width:100%;margin-left:5px}#paypal{box-shadow:0 0 0 1px #e0e0e0;background:#fff;border:none;outline:0;color:#fff;padding:0 12px;border-radius:4px;padding:8px 15px 8px 8px;width:90%;cursor:pointer}#paypal img{width:55px}.card-btn{width:100%;box-shadow:0 0 0 1px #e0e0e0;border:none;border-radius:4px;margin-right:5px;outline:0;text-align:center;background:#f0f0f0;height:30px;margin-top:.5px}.card-btn img{width:16px;vertical-align:middle;height:100%}.card-span{font-size:12px}#paypal-button-container div:nth-of-type(1){min-width:225px!important}.credit-card-container{box-shadow:0 0 0 1px #e0e0e0;border-radius:8px;margin:10px 0}.card-number-container{padding:10px;border-bottom:1px solid rgba(26,26,26,.1)}.expiry-date-container{padding:10px;border-right:1px solid rgba(26,26,26,.1)}.cvc-container{padding:10px}.card-container-ex-cvc{display:grid;grid-template-columns:1fr 1fr}.submit-payment-btn{padding:16px 15px;border:none;cursor:pointer;border-radius:8px;font-weight:700;width:94%;font-size:16px;outline:0;color:#ebf6ff}.payment-btn-ctn{display:flex}

</style>
<script type="text/javascript">
	
	var stripe = Stripe("{{ env('STRIPE_PUB_KEY') }}");

</script>
<script type="text/javascript">

var elements = stripe.elements();

var style = {
    base: {
        fontWeight: 400,
        fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
        fontSize: '13px',
        lineHeight: '1.4',
        color: '#555',
        backgroundColor: '#fff',
        '::placeholder': {
            color: '#888',
        },
    },
    invalid: {
        color: '#eb1c26',
    }
};

var cardElement = elements.create('cardNumber', {
    style: style
});
cardElement.mount('#card_number');

var exp = elements.create('cardExpiry', {
    'style': style
});
exp.mount('#card_expiry');

var cvc = elements.create('cardCvc', {
    'style': style
});
cvc.mount('#card_cvc');

// Validate input of the card elements
var resultContainer = document.getElementById('paymentResponse');
cardElement.addEventListener('change', function(event) {
    if (event.error) {
        resultContainer.innerHTML = '<p>'+event.error.message+'</p>';
    } else {
        resultContainer.innerHTML = '';
    }
});

// Get payment form element
var form = document.getElementById('paymentFrm');

// Create a token when the form is submitted.
form.addEventListener('submit', function(e) {
    e.preventDefault();
    createToken();
});

// Create single-use token to charge the user
function createToken() {
    stripe.createToken(cardElement).then(function(result) {
        if (result.error) {
            // Inform the user if there was an error
            resultContainer.innerHTML = '<p>'+result.error.message+'</p>';
        } else {
            stripeTokenHandler(result.token);
        }
    });
}

// Callback to handle the response from stripe
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);
	
    // Submit the form
    form.submit();
}

	$('.shopping-cart-container').delay(150).slideDown();

	$('main h2').delay(150).fadeIn();

$('.summary-tab').click(function(){
	$('.cart-product-container').slideToggle();
});

$('input[name=billing_checkbox]').click(function(){
	if($(this).is(':checked')){
        $('.billing-address-container').slideUp(200);
        $('.billing-address-container :input').removeAttr('required');
    }else{
        $('.billing-address-container').slideDown(200);
        $('.billing-address-container :input').not($('input[name=billing_address_line_2]')).attr('required','required');
    }
});

</script>


<script type="text/javascript">
	
		paypal.Buttons({
		    locale: 'en_US',
		    style: {
		        height: 31,
		        label:'pay',
		        color: 'blue',
		        layout: 'horizontal',
	    		tagline: 'false',
		    },

	   		createSubscription: function(data, actions) {
	          return actions.subscription.create({
	            plan_id: '{{ env("PAYPAL_PLAN_CODE") }}'
	          });
	        },

	        onApprove: function(data, actions) {
	
	  
	         
	        	console.log(actions);
	            console.log(data);
	           $.ajax({
	                url: "paypal-sub-approved",
	                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
	                method: "POST",
	                data: {sub_id:data.subscriptionID},
	                beforeSend: function () {
	                    // $(".load_ctn").show();
	                },
	                success: function (t) {
	                	var base = window.location.origin;
	                	window.location.replace(base+'/subscription');
	                },
	                error: function (t, e, n) {
	                    console.log(t);
	                },
	            });

	    
	        }
      }).render('#paypal-button-container'); // Renders the PayPal button

</script>


@endsection