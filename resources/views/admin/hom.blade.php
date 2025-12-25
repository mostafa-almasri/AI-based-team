<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>TMS</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('chat.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/meanmenu/meanmenu.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('css/scrollbar/jquery.mCustomScrollbar.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/notika-custom-icon.css')}}">
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">

</head>

<body>

    <!-- Start Header Top Area -->
    <div class="header-top-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="logo-area">
 <a href="{{url('/')}}" style="display: flex;" >         <img  src="{{url('../assets/img/logo.png')}}" alt="" width="50px" height="50px">
                    <h1 style="color:white; margin:10px">TMS</h1></a>
                    </div>
                </div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="margin-top: 15px;">

                    <div class="header-top-menu">
                        <ul class="nav navbar-nav notika-top-nav">
      
                            <li class="nav-item dropdown">
                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span><i class="notika-icon notika-support"></i></span> Admin</a>
                                <div role="menu" class="dropdown-menu message-dd animated zoomIn">

                                    <div class="hd-message-info">
                                    <a href="{{ route('admin.profile') }}" >
                                            <div class="hd-message-sn" style="text-align:center; display:contents">
                                                    <h3 style="color:black">Update profile</h3>
                                            </div>
                                        </a>
                                        <hr>
                                        <a href="{{ route('logout') }}"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <div class="hd-message-sn" style="text-align:center; display:contents">
                                                    <h3 style="color:black">Logout</h3>
                                            </div>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                 
                                </div>
                            </li>
            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Top Area -->
    <!-- Mobile Menu start -->
    <div class="mobile-menu-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="mobile-menu">
                        <nav id="dropdown">
                            <ul class="mobile-menu-nav">
                            <li class="{{ Request::is('home*')  ? 'active' : '' }}"><a data-toggle="collapse"  href="{{url('/home')}}">Home</a>
                                   
                                   </li>
                                   <li class="{{ Request::is('admin/user*')  ? 'active' : '' }}"><a data-toggle="collapse"  href="{{route('admin.show.user')}}">Mangement Manager account</a>
                              
                                   </li>
                
                              
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu end -->
    <!-- Main Menu area start-->
    <div class="main-menu-area mg-tb-40">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                        <li class="{{ Request::is('home*')  ? 'active' : '' }}"><a href="{{url('/home')}}"><i class="notika-icon notika-house"></i> Home</a>
                        </li>
                        <li class="{{ Request::is('admin/user*')  ? 'active' : '' }}"><a  href="{{route('admin.show.user')}}"><i class="notika-icon notika-support"></i> Mangement Manager accounts</a>
                        </li>
                    </ul>
                    <div class="tab-content custom-menu-content">
                        <div class="form-example-area">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-example-wrap mg-t-30">

                                            <div class="cmp-tb-hd cmp-int-hd">
                                            <h2 class="mb-4 text-center">📊 Platform Growth Timeline</h2>
                                            </div>

                                            <div class="hd-message-info hd-task-info">
                                                <div class="bar-chart-area">
                                              
                                                                <div class="bar-chart-wp">
                                                                        <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                                                            <div class="bar-chart-wp">
                                                                            <canvas id="chartTimeline" height="200" class="mt-4"></canvas>
                                                                            </div>
                                                                        </div>
                                                                
                                                                                                                                     
                                                                </div>

                                                    
                                                        </div>
                                                
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Menu area End-->

    <!-- End Footer area-->
    <script src="{{asset('js/charts/Chart.js')}}"></script>

     <script>
        new Chart(document.getElementById("chartTimeline"), {
        type: "line",
        data: {
            labels: @json($data['dates']),
            datasets: [
            {
                label: "Managers Created",
                data: @json($data['managers']),
                borderColor: "blue",
                borderWidth: 2,
                tension: 0.3
            },
            {
                label: "Members Created",
                data: @json($data['member']),
                borderColor: "green",
                borderWidth: 2,
                tension: 0.3
            },
            {
                label: "Projects Created",
                data: @json($data['projects']),
                borderColor: "red",
                borderWidth: 2,
                tension: 0.3
            }
            ]
        },
        options: {
            responsive: true,
            scales: {
            y: { beginAtZero: true }
            }
        }
        });

     </script>
    <script src="{{asset('script.js')}}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="{{asset('js/vendor/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/wow.min.js')}}"></script>
    <script src="{{asset('js/meanmenu/jquery.meanmenu.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
</body>

</html>