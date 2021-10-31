@if(Auth::check())
<div class="input-container">
	<div class="label">
		<div class="tooltip">
			<img class="question_img" src="image/question.png" alt="question mark">
			<div class="right">
				<div class="text-content">
		            <p>Select the date of the sale</p>
				</div>
				<i></i>
			</div>
		</div>
		<div>Sale Date</div>
	</div>
	<div>
		<input type="date" value="2019-01-01" required name="sale_date">
	</div>
</div>

<div class="input-container">
	<div class="label">
		<div class="tooltip">
			<img class="question_img" src="image/question.png" alt="question mark">
			<div class="right">
				<div class="text-content">
		            <p>Enter the name for this sale</p>
				</div>
				<i></i>
			</div>
		</div>
		<div>Name</div>
	</div>
	<div>
		<input class="{{$page}}" type="name" maxlength="20" name="name">
	</div>
</div>
@endif
