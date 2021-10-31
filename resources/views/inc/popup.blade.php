<!-- Popup -->

<!-- @if(!Auth::user())
    <div class="popup-outer">
    	<div class="popup-container">
    		<div class="pop-img-ctn">
    			<img src="image/pop-img.png">
    		</div>
    		<div class="popup-txt-ctn">
    			<div class="popup-txt-inner">
    				<p>New Spreadsheet System For Your Online Sales</p>
    				<div class="popup-btn-ctn">
    					<a href="{{url('/spreadsheet')}}"><button>Try Out For Free</button></a>
    				</div>
    				<p class="no-thx">No Thanks</p>
    			</div>
    		</div>
    	</div>
    </div>
@endif -->


<!-- Referal -->
<!-- 
<div class="popup-outer">
	<div class="popup-container">
		<div class="pop-img-ctn">
			<img class="stars" src="image/star.png">
			<img src="image/amazon.jpg">
		</div>
		<div class="popup-txt-ctn">
			<div class="popup-txt-inner">
				<p>REFER FOR A CHANCE TO WIN A $20 GIFT CARD!</p>
				<p class="text">In celebration of our import system we are giving away gift cards. Refer a friend for a chance of winning a $20 gift card.</p>
				<form>
					<input type="text" name="name">
					<input type="email" name="your_email">
					<input type="email" name="referal_email">
					<div class="popup-btn-ctn">
						<a href="{{url('/spreadsheet')}}"><button>Refer Now</button></a>
					</div>
				</form>
				<p class="no-thx">No Thanks</p>
			</div>
		</div>
	</div>
</div> -->


<!-- <div class="popup-outer"></div>

<div class="popup-container">
	<div class="popup-container-inner">
		<div class="popup-container-img">
			<img src="image/amazon.jpg?12">
		</div>
		<div class="popup-conainer-text">
			<p class="p-title">REFER FOR A CHANCE TO WIN A $20 GIFT CARD!</p>
			<p class="p-text">In celebration of our Import System we are giving away gift cards. Refer a friend for a chance of winning. Winners will be annouced on 2020/05/20</p>
			<form onsubmit="return validate();" autocomplete="off" action="{{ url('mail-referal') }}" method="POST">
				@csrf
				<div>
				@guest
				<input placeholder="Your Name" required type="text" name="name">
				<input placeholder="Your Email" required type="email" name="your_email">
				@else
				<input placeholder="Your Name" value="{{Auth::user()->name}}" required type="text" name="name">
				<input placeholder="Your Email" value="{{Auth::user()->email}}" required type="email" name="your_email">
				@endguest
				</div>
				<input placeholder="Your Friend's Email" required type="email" name="referal_email">
				<div class="error"></div>
				<div class="popup-btn-ctn">
					<button class="refer-btn" type="submit">Refer Now</button>
				</div>
			</form>
			<p class="no-thx">No Thanks</p>
		</div>
	</div>
</div>


<script type="text/javascript">
	
	function validate(){
		if ($("input[name=your_email]").val() == $("input[name=referal_email]").val()) {
			$(".error").text("Email Address Cannot Match. Please Use A Different One.");
			return false;
		}
	}
</script> -->