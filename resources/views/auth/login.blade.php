<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>TMS</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/css/main.css')}}" rel="stylesheet">


</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="{{url('/')}}" class="logo d-flex align-items-center me-auto">
         <img src="{{url('../assets/img/logo.png')}}" alt="">
        <h1 class="sitename">TMS</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{url('/')}}" class="active">Home</a></li>
         
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/home') }}" class="btn-getstarted">My profile</a>
                    @else
                    <a href="{{ route('login') }}" class="btn-getstarted">Login</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-getstarted">Register</a>
                    @endif
                    @endauth
            @endif 
      
    </div>
  </header>

  <main class="main">

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span>Login</span>
        <h2>Login</h2>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row" style="display: flex; justify-content: center;">


          <div class="col-lg-7">
        
            <form action="{{ route('login') }}" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">
              @csrf
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

                <div class="col-md-12">
                  <label for="name-field" class="pb-2">Job ID</label>
                  <input type="text" name="job" id="name-field" class="form-control" required="">
                </div>


                <div class="col-md-12">
                  <label for="message-field" class="pb-2">Password</label>
                  <input type="password" class="form-control" placeholder="Password" name="password" required autocomplete="current-password">
                </div>
                <div class="fm-checkbox">
                        <label><input  type="checkbox" class="i-checks" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> <i></i>Remember me</label>
                </div>
                <div class="col-md-12">
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" >Forgot Password</a>
                @endif
                </div>

                <div class="col-md-12 text-center">
                  

                  <button type="submit">Login</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <!-- Preloader -->
  <div id="preloader"></div>


  <script src="{{asset('assets/js/main.js')}}"></script>

</body>

</html>

