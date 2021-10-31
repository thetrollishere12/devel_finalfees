<?php
$path = storage_path() . "/json/currency.json"; // ie: /var/www/laravel/app/storage/json/filename.json

$json = json_decode(file_get_contents($path), true); 

?>
@if(Auth::check())
<div class="input-container">
	<div class="label">
		<div class="tooltip">
			<img class="question_img" src="image/question.png" alt="question mark">
			<div class="right">
				<div class="text-content">
		            <p>Select the currency you are using.</p>
				</div>
				<i></i>
			</div>
		</div>
		<div>Currency</div>
	</div>
	<div>
		<select name="currency" id="currency">
			@foreach($json as $key => $value)
				@foreach($value as $test)
				<option value="{{ $test['symbol'] }}">{{ $test['code'] }}</option>
				@endforeach
			@endforeach
		</select>
	</div>
</div>
@endif