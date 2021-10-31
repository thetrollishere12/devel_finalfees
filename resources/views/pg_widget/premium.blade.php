<div id="sub_status" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<div class="modal-main">
    		@include('inc.upgrade_acc')
      	</div>
      <div class="modal-footer">
        <button class="left-btn" type="button" data-dismiss="modal">Close</button>
        <a href="{{url('/payment')}}"><button class="right-btn" type="button">Upgrade Now</button></a>
      </div>
    </div>
  </div>
</div>