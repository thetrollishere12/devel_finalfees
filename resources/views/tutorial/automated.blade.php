@extends('layouts.app')

@section('title')
Spreadsheet Sales System Tutorial || Finalfees
@endsection

@section('description')
Tutorial demonstrating on how to use the spreadsheet sales system for online selling platforms such as ebay, etsy, grailed, poshmark, depop and many more
@endsection

@section('content')
<div class="tutorial-container">
  <h1>How To Use The<br>Automated Sales Tracker System</h1>
  
  <div class="tutorial-inner">
      <video width="100%" controls>
        <source src="{{asset('image/finalfees.mp4')}}" type="video/mp4">
          <source src="{{asset('image/finalfees.ogg')}}" type="video/ogg">
      </video>
  </div>

  <div class="tutorial-inner">
    <div>
      <img alt="Creating a spreadsheet" class="tutorial-img" src="{{ asset('image/auto-pt1.jpg?1') }}">
      <figcaption><b>Step 1.</b> <b>Click</b> on <b>Add Account</b> under account at the top of the page.</figcaption>
    </div>
  </div>
  
  <div class="tutorial-inner">
    <div>
      <img alt="Creating a spreadsheet" class="tutorial-img" src="{{ asset('image/auto-pt2.jpg?1') }}">
      <figcaption><b>Step 2.</b> Login with your seller's account.</figcaption>
    </div>
  </div>
  
  <div class="tutorial-inner">
    <div>
      <img alt="Creating and saving your spreadsheet" class="tutorial-img" src="{{ asset('image/auto-pt3.jpg?1') }}">
      <figcaption><b>Step 3.</b> After your seller's account has successfully been added, <b>Click</b> on <b>Sold Listing</b>.</figcaption>
    </div>
  </div>
  
  <div class="tutorial-inner">
    <div>
      <img alt="Spreadsheet list at the bottom of the page" class="tutorial-img" src="{{ asset('image/auto-pt4.jpg?1') }}">
      <figcaption><b>Step 4.</b> All your sales should show up from the past months. <b>Click</b> on the <b>left side</b> for the sales you want entered in your spreadsheet. Make sure you have a <b>spreadsheet already created</b> at the <b>bottom of the page</b>.</figcaption>
    </div>
  </div>
  
  <div class="tutorial-inner">
    <div>
      <img alt="Adding your online sales to your spreadsheet" class="tutorial-img" src="{{ asset('image/auto-pt5.jpg?1') }}">
      <figcaption><b>Step 5.</b> Under the <b>yellow labels</b> you can enter your desired amount for <b>cost</b>. After you are satisfied, click on <b>"Add To"</b> to the desired spreadsheet.</figcaption>
    </div>
  </div>
  
  <div class="tutorial-inner">
    <div>
      <img alt="Successfully adding a sale to your spreadsheet" class="tutorial-img" src="{{ asset('image/auto-pt6.jpg?1') }}">
      <figcaption>That's it, you should see a green popup message saying <b>"The selected sales has been added!"</b> <b><a href="{{url('/auto')}}">Click here to try it now.</a></b></figcaption>
    </div>
  </div>
  
  <br>
</div>  
@endsection