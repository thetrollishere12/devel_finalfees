@extends('layouts.app')

@section('title')
Spreadsheet Sales System Tutorial || Finalfees
@endsection

@section('description')
Tutorial demonstrating on how to use the spreadsheet sales system for online selling platforms such as ebay, etsy, grailed, poshmark, depop and many more
@endsection

@section('content')
<div class="tutorial-container">
  <h1>How To Create & Add<br>Your Sales To Your Spreadsheet</h1>
  
  <div class="tutorial-inner">
    <div>
      <img alt="Creating a spreadsheet" class="tutorial-img" src="{{ asset('image/sheet-pt1.jpg?1') }}">
      <figcaption><b>Step 1.</b> <b>Click</b> on <b>Create Spreadsheet</b> at the bottom of the page.</figcaption>
    </div>
  </div>
  
  <div class="tutorial-inner">
    <div>
      <img alt="Creating and naming your spreadsheet" class="tutorial-img" src="{{ asset('image/sheet-pt2.jpg?1') }}">
      <figcaption><b>Step 2.</b> Type in the desired name you want to call your spreadsheet.</figcaption>
    </div>
  </div>
  
  <div class="tutorial-inner">
    <div>
      <img alt="Creating and saving your spreadsheet" class="tutorial-img" src="{{ asset('image/sheet-pt3.jpg?1') }}">
      <figcaption><b>Step 3.</b> Click <b>Create</b> after you are satisfied with the name.</figcaption>
    </div>
  </div>
  
  <div class="tutorial-inner">
    <div>
      <img alt="Spreadsheet list at the bottom of the page" class="tutorial-img" src="{{ asset('image/sheet-pt4.jpg?1') }}">
      <figcaption><b>Step 4.</b> After that you should see your <b>Spreadsheet List</b> at the <b>bottom</b>. Now <b>Enter In</b> all the information about your sale.</figcaption>
    </div>
  </div>
  
  <div class="tutorial-inner">
    <div>
      <img alt="Adding your online sales to your spreadsheet" class="tutorial-img" src="{{ asset('image/sheet-pt5.jpg?1') }}">
      <figcaption><b>Step 5.</b> Click on <b>"Add To"</b> to the desired spreadsheet.</figcaption>
    </div>
  </div>
  
  <div class="tutorial-inner">
    <div>
      <img alt="Successfully adding a sale to your spreadsheet" class="tutorial-img" src="{{ asset('image/sheet-pt6.jpg?1') }}">
      <figcaption>That's it, you should see a popup message saying <b>"Added To Spreadsheet."</b></figcaption>
    </div>
  </div>
  
  <div class="tutorial-inner">
    <div>
      <img alt="Checking your entered sale in your spreadsheet" class="tutorial-img" src="{{ asset('image/sheet-pt7.jpg?1') }}">
      <figcaption>Head to your <b><a href="{{url('/spreadsheet')}}">Spreadsheets</a></b> and you should be able to see it. <b><a href="{{url('/spreadsheet')}}">Click here to try it now.</a></b></figcaption>
    </div>
  </div>
  
  <br>
</div>  
@endsection