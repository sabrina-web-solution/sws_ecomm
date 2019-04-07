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
                <a class="navbar-brand" href="">
                    <img src="{{ asset('website/images/logo.png') }}" height="100px" alt="SWS Ecommerce">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topbar" aria-controls="topbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse mt-2" id="topbar">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="">Home <span class="sr-only"></span></a>
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
                        @endif
                        <li class="cart-icon">
		            		<a href="{{route('cart')}}">
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

    @yield('content')


    <!-- Login signup modal -->
    <div class="modal login-wp fade bd-example-modal-lg" id="loginregister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h2>Recent Login:</h2>
            <ul class="tp-pro">
              @for($i=1; $i<=4; $i++)
                @if(Session::get('last_login_'.$i))
                  <li>
                    <span class="profile-img last_login_img" data-email="{{Session::get('last_login_email_'.$i)}}" data-pwd="{{Session::get('last_login_password_'.$i)}}" data-remem="{{Session::get('last_login_remember_'.$i)}}" ><img src="{{asset('images/landing/John.jpg')}}" alt=""></span>
                    <p>{{Session::get('last_login_name_'.$i)}}</p>
                  </li>
                @endif
                
              @endfor
             
            </ul>
            <div class="tabing-box">
              
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="Login-tab" data-toggle="tab" href="#Login" role="tab" aria-controls="Login" aria-selected="true">Login</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="Signup-tab" data-toggle="tab" href="#Signup" role="tab" aria-controls="Signup" aria-selected="false">Signup</a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">

                  <div class="tab-pane fade show active" id="Login" role="tabpanel" aria-labelledby="Login-tab">
                  
                    <form id="login_form">
                      {{@csrf_field()}}

                      <div class="form-group">
                        <input type="email" id="email"  name="email" placeholder="Email Address" class="form-control"  value="<?php
                            echo (isset($_COOKIE["swoope_email"]))?$_COOKIE["swoope_email"]:""
                          ?>"
                        >
                      </div>

                      <div class="form-group">                 
                        <input type="password" id="password" name="password" placeholder="Password" class="form-control" value="<?php
                            echo (isset($_COOKIE["swoope_paswd"]))?$_COOKIE["swoope_paswd"]:""
                          ?>">
                      </div>
                      <div class="form-group">
                        <span class="lft-col ml-2">
                        <span class="custom-check">
                        <input type="checkbox" id="signed" name="remember_me" <?php
                            echo (isset($_COOKIE["swoope_paswd"]))?"checked":""
                          ?>>
                        <label for="signed">Keep me signed in</label>
                        </span>
                        </span>
                        <span class="forgot-pass"><a href="#">Forgot Password?</a></span>
                      </div>
                      <div class="form-group text-center">
                        <button type="button" class="btn-primery" id="login">Login</button>
                      </div>
                    </form>

                  </div>

                  <div class="tab-pane fade" id="Signup" role="tabpanel" aria-labelledby="Signup-tab">
                    <div class="result"></div>
                    <form method="POST" id="register_form">
                      {{@csrf_field()}}

                      <div class="form-group">
                        <input type="text"  name="name" class="form-control" placeholder="Your Name">
                      </div>

                      <div class="form-group">
                        <input type="email"  name="email" placeholder="Email ID" class="form-control">
                      </div>

                      <div class="form-group">
                        <input type="text" name="mobile" placeholder="Mobile Number" class="form-control">
                      </div>

                      <div class="form-group">                   
                        <input type="password" name="password" placeholder="Password" class="form-control">
                      </div>

                      <div class="form-group" style="position: relative;">       
                        <label for="password">DOB:</label>&nbsp;&nbsp;&nbsp; 
                        <input type="date" name="dob"  class="form-control" id="calendar"> 
                        <!-- <span class="fa fa-calendar" id="datepickericon" ></span> -->

                                                
                      </div>

                      <div class="form-group">
                        <label for="password">Gender:</label>&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="gender"  value="male" >Male
                        <input type="radio" name="gender"  value="female">Female
                      </div>

                      <div class="form-group text-center">
                        <button type="button" class="btn-primery" id="register">SignUp</button>
                      </div>
                    </form>
                  </div>

                </div>            
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->

    <script src="{{ asset('website/js/jquery-3.3.1.slim.min.js') }}"></script>
    <script src="{{ asset('website/js/bootstrap.min.js') }}"></script>  
    <script src="{{ asset('website/js/all.min.js') }}"></script>  
    <script src="{{ asset('website/js/custom.js') }}"></script>      
    <script>
    $(document).ready(function(){
        

    });
    </script>
</body>
</html>