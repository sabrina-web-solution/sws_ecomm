<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SWS Ecommerce</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('website/images/favicon.png') }}" />

    <link rel="stylesheet" href="{{ asset('website/css/reset.css') }}">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet"> -->

    <link rel="stylesheet" type="text/css" href="{{ asset('website/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('website/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('website/css/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('website/css/custom.css') }}">

</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <a class="navbar-brand" href="{{route('welcome')}}">
                    <img src="{{ asset('website/images/logo.png') }}" height="100px" alt="SWS Ecommerce">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topbar" aria-controls="topbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="topbar">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{route('welcome')}}">Home <span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="top-left"  id="menulogin" href="javascript:void(0)"  style="display: {{ (Auth::user())?'none':'' }}" data-toggle="modal" data-target="#loginregister">Login/Register</a>      
                        </li>
                        @if(Auth::user())
                        <li class="nav-item dropdown profile-wp"  style="display: {{ (Auth::user())?'':'none' }}" >
                            <div class="profile-icon">
                            <img src="{{ asset('website/images/'. (!empty(Auth::user()->image))?(Auth::user()->image):'shop1.png') }}">
                            <span class="profile-name">Welcome {{(Auth::user())?Auth::user()->name:'Guest'}}</span>
                            </div>

    		              	<a class="" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			                	<img src="{{ asset('website/images/drop.svg') }}" align="">
			              	</a>
			              	<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				                <a class="dropdown-item" href="{{route('getAccountDetails')}}">Your Account</a>
				                <a class="dropdown-item" href="{{route('getOrderDetails')}}">Your Orders</a>
				                <!-- <a class="dropdown-item" href="#">Switch Account</a> -->
				                <a class="dropdown-item" id="menulogout" style="display: {{ (Auth::user())?'':'none' }}" href="{{route('logout')}}">Logout</a>
			              	</div>
		            	</li>
                        <li class="cart-icon">
		            		<a href="{{route('getCartDetails')}}">
		            			<img src="{{ asset('website/images/cart.svg') }}" align=""><span class="badge" id="countCart" style="color:inherit;right: 18px; bottom: -10px; z-index: 999; position: relative;"></span>
		            		</a>
		            	</li>
                    </ul>
                    <form class="form-inline mt-2 mt-md-0">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </nav>
        </div>
    </header>



    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->

    <script src="{{ asset('website/js/jquery-3.3.1.slim.min.js') }}"></script>
    <script src="{{ asset('website/js/bootstrap.min.js') }}"></script>  
    <script src="{{ asset('website/js/all.min.js') }}"></script>  
    <script src="{{ asset('website/js/custom.js') }}"></script>      

</body>
</html>