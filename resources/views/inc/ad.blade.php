@if(Auth::user() && !Auth::user()->subscribed('main'))
<div class="ad-container">
    <ins class="adsbygoogle"
     style="display:block"
     data-ad-format="fluid"
     data-ad-layout-key="-6t+ed+2i-1n-4w"
     data-ad-client="ca-pub-6735725085331799"
     data-ad-slot="5177592026">
    </ins>
</div>

@elseif(!Auth::user())
<div class="ad-container">
    <ins class="adsbygoogle"
     style="display:block"
     data-ad-format="fluid"
     data-ad-layout-key="-6t+ed+2i-1n-4w"
     data-ad-client="ca-pub-6735725085331799"
     data-ad-slot="5177592026">
    </ins>
</div>
@endif

