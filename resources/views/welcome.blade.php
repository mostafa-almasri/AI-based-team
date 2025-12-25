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

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
            <h1>Welcome to <br>  Task Management system</h1>
            <p>Your collaborative space for task management and team coordination.</p>
           
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="100">
            <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span>About Us<br></span>
        <h2>About</h2>
        <p>Management task and adminstrator members</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">
          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="100">
            <img src="assets/img/about.png" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="200">
            <h3>Leading Collaborative Project Management.</h3>
        
            <ul>
              <li><i class="bi bi-check2-all"></i> <span> A project and task management platform designed for modern teams.</span></li>
              <li><i class="bi bi-check2-all"></i> <span>We empower teams to create and coordinate teams, add projects and tasks, and track progress centrally and transparently.</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Our solutions enhance collaboration, improve organization, and shorten turnaround times through a simple and efficient interface, with the potential to scale across multiple organizations and collaborations.</span></li>
            </ul>
            <p>
              Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
              velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident
            </p>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

  </main>

  <!-- Preloader -->
  <div id="preloader"></div>


  <script src="{{asset('assets/js/main.js')}}"></script>

</body>

</html>