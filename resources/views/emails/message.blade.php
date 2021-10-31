@if($inputs->textarea)
<p>Suggestions</p>
{{ $inputs->textarea }}
@else
<p>Email:</p>
{{ $inputs->email }}

<p>Subject:</p>
{{ $inputs->subject }}

<p>Description</p>
{{ $inputs->description }}
@endif