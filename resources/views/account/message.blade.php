@extends('layouts.noapp')
@section('title')
	Message
@endsection()
@section('content')
	<div class="message-container">
		<form action="{{url('/send_msg')}}" method="POST">
			@csrf
			<h1>Send Message</h1>
			<div>
				<select name="select">
					<option value="General Inquiry">General Inquiry</option>
					<option value="Subscription">Subscription</option>
					<option value="Tech Issues">Technical Issue(s)</option>
					<option value="Account">My Account</option>
					<option value="Paymment Issues">Payment Issue(s)</option>
					<option value="Bug Report">Reporting A Bug</option>
					<option value="Feedback">Feedback</option>
					<option value="Other">Other</option>
				</select>
			</div>
			@if(!auth::User())
			<div>
				<p class="must">Your Email Address</p>
				<input type="email" name="email" required>
			</div>
			@else
			<input type="hidden" name="email" value="{{ Auth::user()->email }}" required>
			@endif
			<div>
				<p class="must">Subject</p>
				<input type="text" name="subject" required>
			</div>
			<div>
				<p class="must">Description</p>
				<textarea rows="10" name="description" cols="50" required></textarea>
			</div>
	<!-- 		<div>
				<p>Attachments</p>
				<input type="file" name="file" accept="file_extension|video/*|image/*|media_type">
			</div> -->
			<div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>

			@if($errors->any())
	            <div><b style="color:#ff3d50!important;">{{$errors->first()}}</b></div>
	        @endif

			<button id="submitBtn" disabled type="submit">Send</button>
		</form>
	</div>
	<script>
	    function recaptchaCallback() {
            $('#submitBtn').removeAttr('disabled');
        };
	</script>
@endsection