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
    <link rel="stylesheet" href="{{asset('chat.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.theme.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.transitions.css')}}">
    <!-- meanmenu CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/meanmenu/meanmenu.min.css')}}">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/normalize.css')}}">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/scrollbar/jquery.mCustomScrollbar.min.css')}}">
    <!-- jvectormap CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/jvectormap/jquery-jvectormap-2.0.3.css')}}">
    <!-- notika icon CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/notika-custom-icon.css')}}">
    <!-- wave CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/wave/waves.min.css')}}">
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

    
<style>
  /* ✅ تحسين عرض القائمة وتوسيطها */
.header-top-menu .nav.notika-top-nav li .message-dd {
    width: 500px !important; /* تحديد عرض القائمة */
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

/* ✅ التأكد من أن النصوص تنتقل للسطر التالي دون اقتطاع */
.hd-mg-ctn {
    max-width: 100%; /* السماح للنص بالامتداد داخل العنصر */
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;
    padding: 5px;
}

/* ✅ تحديد ارتفاع القائمة مع تفعيل التمرير */
.hd-message-info {
    max-height: 250px; /* ضبط الحد الأقصى للارتفاع */
    overflow-y: auto;
    scroll-behavior: smooth;
    padding: 10px;
    position: relative;
}

/* ✅ تحسين شريط التمرير */
.hd-message-info::-webkit-scrollbar {
    width: 6px;
}

.hd-message-info::-webkit-scrollbar-thumb {
    background: #8BC34A;
    border-radius: 5px;
}

.hd-message-info::-webkit-scrollbar-track {
    background: #f1f1f1;
}

/* ✅ ضبط خلفية الإشعارات المقروءة وغير المقروءة */
.hd-message-sn {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.hd-message-sn.unread {
    background-color: #fff3cd !important; /* خلفية مميزة لغير المقروء */
}

.hd-message-sn.read {
  background-color: transparent !important; /* إزالة الخلفية */
}



</style>
</head>

<body>

    <!-- Start Header Top Area -->
    <div class="header-top-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="logo-area">
                    <a href="{{url('/')}}"> <h1 style="color:white;">Al-Based team</h1></a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="header-top-menu">
                        <ul class="nav navbar-nav notika-top-nav">
                            <li class="nav-item" style="margin-right: 20px;">
                                <div class="nk-toggle-switch" style="margin-top: 20px;">
                                    <label for="availability-toggle" class="ts-label" style="color:white;">{{ $availability->is_available ? 'Availaible' : 'Busy' }}</label>
                                    <input id="availability-toggle" type="checkbox" hidden {{ $availability->is_available ? 'checked' : '' }}>
                                    <label for="availability-toggle" class="ts-helper"></label>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a style="padding:20px 20px 20px 5px;" href="#" id="markAsRead" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                    <span> <i class="notika-icon notika-mail"></i></span>
                                    @if($unreadMessagesCount == 0)
                                  <div class="ntd-ctn"> <span id="unreadCount">{{ $unreadMessagesCount }}</span></div>
                                    @else
                                    <div class="spinner4 spinner-4"></div><div class="ntd-ctn"> <span id="unreadCount">{{ $unreadMessagesCount }}</span></div>
                                    @endif
                                </a>
                                    <script>
                                    document.getElementById('markAsRead').addEventListener('click', function(event) {
                                        event.preventDefault(); // منع إعادة التحميل

                                        fetch("{{ route('markAsRead') }}", {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            }
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                // تحويل العدد إلى صفر
                                                document.getElementById('unreadCount').textContent = 0;
                                            }
                                        })
                                        .catch(error => console.error('Fetch Error:', error));
                                    });
                                </script>   
                              <div role="menu" class="dropdown-menu message-dd animated zoomIn">
                                  <div class="hd-mg-tt">
                                      <h2>Chat with Manger</h2>
                                  </div>
                                  <div class="hd-message-info">
                                      @if($user->count() > 0)
                                          @foreach($user as $row)
                                              <a href="{{ route('chat.manger', ['id' => $row->id]) }}">
                                                  <div class="hd-message-sn">
                                                      <div class="hd-message-img">
                                                          <img src="{{ asset('profile.png') }}" alt="" />
                                                      </div>
                                                      <div class="hd-mg-ctn">
                                                          <h3>{{ $row->name }}</h3>
                                                          <p>{{ $row->email }}</p>
                                                          @if($unreadMessages->has($row->id))
                                                              <span class="badge badge-danger">
                                                                  {{ $unreadMessages[$row->id]->unread_count }} new messages
                                                              </span>
                                                          @endif
                                                      </div>
                                                  </div>
                                              </a>
                                          @endforeach
                                      @else
                                      <h4 class="text-center">No manager yet for chat</h4>
                                          
                                      @endif
                                  </div>
                              </div>
                            </li>
                              <script>
                                function scrollNotifications(direction) {
                                    let list = document.getElementById("notification-list");
                                    let scrollAmount = 80; // مقدار التمرير

                                    list.scrollBy({
                                        top: scrollAmount * direction,
                                        behavior: "smooth"
                                    });
                                }
                              </script>
                            <li class="nav-item dropdown">
                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span><i class="notika-icon notika-support"></i></span> {{Auth::user()->name}}</a>
                                <div role="menu" class="dropdown-menu message-dd animated zoomIn">

                                    <div class="hd-message-info">
                                    <a href="{{ route('member.profile') }}" >
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
                              <script>
                                document.getElementById('availability-toggle').addEventListener('change', function() {
                                    fetch("{{ route('student.toggleAvailability') }}", {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            // تغيير النص حسب الحالة الجديدة
                                            const label = document.querySelector('label[for="availability-toggle"].ts-label');
                                            label.textContent = data.is_available ? 'Availabile' : 'Busy';
                                        }
                                    })
                                    .catch(error => console.error('Error:', error));
                                });
                              </script>
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
                                <li><a data-toggle="collapse"  href="{{url('/home')}}">Home</a>
                                   
                                </li>
                                <li><a data-toggle="collapse" href="{{route('member.show.task')}}">My Tasks</a>
  
                                </li>
                
                                <li><a data-toggle="collapse"  href="{{route('member.show.skill')}}">Skills</a>
                              
                                </li>
                                <li><a data-toggle="collapse"  href="{{route('member.show.team')}}">Team group</a>
                         
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
                        <li class="active"><a  href="{{url('/home')}}"><i class="notika-icon notika-house"></i> Home</a>
                        </li>
                        <li><a  href="{{route('member.show.task')}}"><i class="notika-icon notika-support"></i> My Tasks</a>
                        </li>
               
                        <li><a  href="{{route('member.show.skill')}}"><i class="notika-icon notika-form"></i> Skills</a>
                        </li>
                        <li><a  href="{{route('member.show.team')}}"><i class="notika-icon notika-windows"></i> Team group</a>
                        </li>
                        </li>
                    </ul>
                    <div class="tab-content custom-menu-content">
                      
            
                    @yield('content')

                  
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Menu area End-->
    <script>
    $(document).ready(function() {
        $('select').select2({
            placeholder: "Select a skill",
            allowClear: true
        });
    });
</script>

    <!-- End Footer area-->
    <!-- jquery
		============================================ -->
    <script src="{{asset('script.js')}}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>


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
    <!-- jvectormap JS
		============================================ -->
    <script src="{{asset('js/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{asset('js/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{asset('js/jvectormap/jvectormap-active.js')}}"></script>
    <!-- sparkline JS
		============================================ -->
    <script src="{{asset('js/sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('js/sparkline/sparkline-active.js')}}"></script>
    <!-- sparkline JS
		============================================ -->
    <script src="{{asset('js/flot/jquery.flot.js')}}"></script>
    <script src="{{asset('js/flot/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('js/flot/curvedLines.js')}}"></script>
    <script src="{{asset('js/flot/flot-active.js')}}"></script>
    <!-- knob JS
		============================================ -->
    <script src="{{asset('js/knob/jquery.knob.js')}}"></script>
    <script src="{{asset('js/knob/jquery.appear.js')}}"></script>
    <script src="{{asset('js/knob/knob-active.js')}}"></script>
    <!--  wave JS
		============================================ -->
    <script src="{{asset('js/wave/waves.min.js')}}"></script>
    <script src="{{asset('js/wave/wave-active.js')}}"></script>
    <!--  todo JS
		============================================ -->
    <script src="js/todo/jquery.todo.js')}}"></script>
    <!-- plugins JS
		============================================ -->
    <script src="{{asset('js/plugins.js')}}"></script>
	<!--  Chat JS
		============================================ -->
    <script src="{{asset('js/chat/moment.min.js')}}"></script>
    <script src="{{asset('js/chat/jquery.chat.js')}}"></script>
    <!-- main JS
		============================================ -->
    <script src="{{asset('js/main.js')}}"></script>
	<!-- tawk chat JS
		============================================ -->
</body>

</html>