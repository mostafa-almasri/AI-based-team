<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Al-Based team</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- font awesome CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.theme.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.transitions.css')}}">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/normalize.css')}}">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/scrollbar/jquery.mCustomScrollbar.min.css')}}">
    <!-- wave CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/wave/waves.min.css')}}">
    <!-- Notika icon CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/notika-custom-icon.css')}}">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">
    <!-- modernizr JS
		============================================ -->
    <script src="{{asset('js/vendor/modernizr-2.8.3.min.js')}}"></script>
</head>

<body>
<div class="header-top-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="logo-area">
                        <a href="{{url('/')}}"> <h1 style="color:white;">Al-Based team</h1></a>
                    </div>
                </div>
              
            </div>
        </div>
    </div>
  
    <!-- Login Register area Start-->
    <div class="login-content">
        <!-- Login -->
        <div class="nk-block toggled" id="l-login">
        <h2>Sign in Al-Based team</h2>
   
            <form method="POST" action="{{ route('login') }}">
                        @csrf
                <div class="nk-form">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif    
                        @if(session('status'))
                            <h6 class="alert alert-success" style="text-align: center;">
                                {{session('status')}}
                            </h6>
                        @endif
                    <div class="input-group">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-support"></i></span>
                        <div class="nk-int-st">
                            <input type="integer" class="form-control" placeholder="Username"  name="job"  required  autofocus>
                        </div>
                    </div>
                    <div class="input-group mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-edit"></i></span>
                        <div class="nk-int-st">
                            <input type="password" class="form-control" placeholder="Password" name="password" required autocomplete="current-password">
                        </div>
                    </div>
                    <div class="fm-checkbox">
                        <label><input type="checkbox" class="i-checks" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> <i></i> Keep me signed in</label>
                    </div>
                    <button type="submit" class="btn btn-login btn-success btn-float"><i class="notika-icon notika-right-arrow right-arrow-ant"></i></button>
                    @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                </div>


            </form>
          
            <div class="nk-navigation nk-lg-ic">
                <a href="#" data-ma-action="nk-login-switch" data-ma-block="#l-register"><i class="notika-icon notika-plus-symbol"></i> <span>Register</span></a>
            </div>
        </div>

        <!-- Register -->
        <div class="nk-block" id="l-register">
            <h2>Register in Al-Based team</h2>

            <form method="POST" action="{{ route('register') }}">
                    @csrf      
                <div class="nk-form">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif    
                        @if(session('status'))
                            <h6 class="alert alert-success" style="text-align: center;">
                                {{session('status')}}
                            </h6>
                        @endif
                    <div class="input-group">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-support"></i></span>
                        <div class="nk-int-st">
                            <input type="text" class="form-control" name="name" placeholder="Username" required>
                        </div>
                    </div>

                    <div class="input-group mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-mail"></i></span>
                        <div class="nk-int-st">
                            <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                        </div>
                    </div>
                  
                    <div class="input-group">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-form"></i></span>
                        <div class="nk-int-st">
                            <input type="text" class="form-control" placeholder="Enter Age between 20 and 60"  name="age" value="{{ old('age') }}" >
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-phone"></i></span>
                        <div class="nk-int-st">
                            <input type="text" class="form-control" placeholder="Phone"  name="phone" value="{{ old('phone') }}" >
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-support"></i></span>
                        <div class="nk-int-st">
                            <input type="text" class="form-control" placeholder="Enter Job id exactly 9 digits"  name="job" value="{{ old('job') }}" >
                        </div>
                    </div>

                    <div class="input-group mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-edit"></i></span>
                        <div class="nk-int-st">
                            <input type="password" name="password" class="form-control" placeholder="Password" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="input-group mg-t-15">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-edit"></i></span>
                        <div class="nk-int-st">
                            <input type="password" class="form-control" placeholder="Confirm Password" id="password-confirm"  name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>


                    <button type="submit" class="btn btn-login btn-success btn-float"><i class="notika-icon notika-right-arrow"></i></button>
                </div>
            </form>

            <div class="nk-navigation rg-ic-stl">
                <a href="#" data-ma-action="nk-login-switch" data-ma-block="#l-login"><i class="notika-icon notika-right-arrow"></i> <span>Sign in</span></a>
            </div>
        </div>


    </div>
    <!-- Login Register area End-->
    <!-- jquery
		============================================ -->
    <script src="{{asset('js/vendor/jquery-1.12.4.min.js')}}"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- wow JS
		============================================ -->
    <script src="{{asset('js/wow.min.js')}}"></script>
    <!-- price-slider JS
		============================================ -->
    <script src="{{asset('js/jquery-price-slider.js')}}"></script>
    <!-- owl.carousel JS
		============================================ -->
    <script src="{{asset('js/owl.carousel.min.js')}}"></script>
    <!-- scrollUp JS
		============================================ -->
    <script src="{{asset('js/jquery.scrollUp.min.js')}}"></script>
    <!-- meanmenu JS
		============================================ -->
    <script src="{{asset('js/meanmenu/jquery.meanmenu.js')}}"></script>
    <!-- counterup JS
		============================================ -->
    <script src="{{asset('js/counterup/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('js/counterup/waypoints.min.js')}}"></script>
    <script src="{{asset('js/counterup/counterup-active.js')}}"></script>
    <!-- mCustomScrollbar JS
		============================================ -->
    <script src="{{asset('js/scrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <!-- sparkline JS
		============================================ -->
    <script src="{{asset('js/sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('js/sparkline/sparkline-active.js')}}"></script>
    <!-- flot JS
		============================================ -->
    <script src="{{asset('js/flot/jquery.flot.js')}}"></script>
    <script src="{{asset('js/flot/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('js/flot/flot-active.js')}}"></script>
    <!-- knob JS
		============================================ -->
    <script src="{{asset('js/knob/jquery.knob.js')}}"></script>
    <script src="{{asset('js/knob/jquery.appear.js')}}"></script>
    <script src="{{asset('js/knob/knob-active.js')}}"></script>
    <!--  Chat JS
		============================================ -->
    <script src="{{asset('js/chat/jquery.chat.js')}}"></script>
    <!--  wave JS
		============================================ -->
    <script src="{{asset('js/wave/waves.min.js')}}"></script>
    <script src="{{asset('js/wave/wave-active.js')}}"></script>
    <!-- icheck JS
		============================================ -->
    <script src="{{asset('js/icheck/icheck.min.js')}}"></script>
    <script src="{{asset('js/icheck/icheck-active.js')}}"></script>
    <!--  todo JS
		============================================ -->
    <script src="{{asset('js/todo/jquery.todo.js')}}"></script>
    <!-- Login JS
		============================================ -->
    <script src="{{asset('js/login/login-action.js')}}"></script>
    <!-- plugins JS
		============================================ -->
    <script src="{{asset('js/plugins.js')}}"></script>
    <!-- main JS
		============================================ -->
    <script src="{{asset('js/main.js')}}"></script>
</body>

</html>