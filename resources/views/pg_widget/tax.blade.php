<div class="input-container">
	<div class="label">
		<div class="tooltip">
			<img class="question_img" src="image/question.png" alt="question mark">
			<div class="right">
				<div class="text-content">
		            <p>Enter the tax percentage you are charged.</p>
				</div>
				<i></i>
			</div>
		</div>
		<div>Tax Rate</div>
	</div>
	<div class="tax-container">
		@if(Auth::user())
		<input type="number" id="{{ Auth::user()->tax }}" oninput="nmb_length(this)" value="{{ Auth::user()->tax }}" maxlength="6" name="item_tax">
		@else
		<input type="number" id="" oninput="nmb_length(this)" maxlength="6" name="item_tax">
		@endif
		<div class="symbol">%</div>
	</div>
</div>