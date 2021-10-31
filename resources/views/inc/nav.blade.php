<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
	<div class="shadow"></div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav">
                <!-- Authentication Links -->
					<li class="nav-item">
                        <a class="nav-link" href="{{url('/')}}">{{ __('Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="showLeft">{{ __('Menu') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/message')}}" id="showLeft">{{ __('Contact Us') }}</a>
                    </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('expense') }}">{{ __('Enter Expense') }}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{url('/spreadsheet')}}">
                                Spreadsheet
                            </a>
                            <a class="dropdown-item" href="{{url('/auto')}}">
                                Auto System
                            </a>
                            <a class="dropdown-item" href="{{url('expense')}}">
                                Enter Expense
                            </a>
                            <a class="dropdown-item" href="{{url('/home')}}">
                                Account Setting
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
 
</nav>
<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
	<div id="outer-nav">
		<div class="outer-arrow">
			<h2>Menu</h2>
			<div class="icon-arrow-left" id="goback"></div>
		</div>
		<a href="{{url('/amazon')}}" title="Amazon profit fee calculator."><h3>Amazon Fee Calculator</h3></a>
		<a href="{{url('/bonanza')}}" title="Bonanza profit fee calculator."><h3>Bonanza Fee Calculator</h3></a>
        <a href="{{url('/chairish')}}" title="Chairish profit fee calculator."><h3>Chairish Fee Calculator</h3></a>
        <a href="{{url('/craigslist')}}" title="Craigslist profit fee calculator."><h3>Craigslist Fee Calculator</h3></a>
		<a href="{{url('/depop')}}" title="Depop profit fee calculator."><h3>Depop Fee Calculator</h3></a>
		<a href="{{url('/ebay')}}" title="Ebay profit fee calculator."><h3>Ebay Fee Calculator</h3></a>
        <a href="{{url('/ecrater')}}" title="Ecrater profit fee calculator."><h3>Ecrater Fee Calculator</h3></a>
		<a href="{{url('/etsy')}}" title="Etsy profit fee calculator."><h3>Etsy Fee Calculator</h3></a>
        <a href="{{url('/facebook-marketplace')}}" title="Facebook profit fee calculator."><h3>Facebook Fee Calculator</h3></a>
		<a href="{{url('/fiverr')}}" title="Fiverr profit fee calculator."><h3>Fiverr Fee Calculator</h3></a>
		<a href="{{url('/goat')}}" title="Goat profit fee calculator."><h3>Goat Fee Calculator</h3></a>
		<a href="{{url('/grailed')}}" title="Grailed profit fee calculator."><h3>Grailed Fee Calculator</h3></a>
         <a href="{{url('/kijiji')}}" title="Kijiji profit fee calculator."><h3>Kijiji Fee Calculator</h3></a>
        <a href="{{url('/letgo')}}" title="Letgo profit fee calculator."><h3>Letgo Fee Calculator</h3></a>
		<a href="{{url('/mercari')}}" title="Mercari profit fee calculator."><h3>Mercari Fee Calculator</h3></a>
         <a href="{{url('/newegg')}}" title="Newegg profit fee calculator."><h3>Newegg Fee Calculator</h3></a>
        <a href="{{url('/offerup')}}" title="OfferUp profit fee calculator."><h3>OfferUp Fee Calculator</h3></a>
		<a href="{{url('/paypal')}}" title="Paypal profit fee calculator."><h3>Paypal Fee Calculator</h3></a>
		<a href="{{url('/poshmark')}}" title="Poshmark profit fee calculator."><h3>Poshmark Fee Calculator</h3></a>
         <a href="{{url('/rakuten')}}" title="Rakuten profit fee calculator."><h3>Rakuten Fee Calculator</h3></a>
          <a href="{{url('/rubylane')}}" title="Rubylane profit fee calculator."><h3>Rubylane Fee Calculator</h3></a>
		<a href="{{url('/stockx')}}" title="StockX profit fee calculator."><h3>StockX Fee Calculator</h3></a>
		<a href="{{url('/stripe')}}" title="Stripe profit fee calculator."><h3>Stripe Fee Calculator</h3></a>
		<a href="{{url('/tradesy')}}" title="Tradesy profit fee calculator."><h3>Tradesy Fee Calculator</h3></a>
        @guest

        @else
        <a href="{{url('/expense')}}" title="Enter expense fee."><h3>Enter Expense</h3></a>
        @endguest
	</div>
</div>


