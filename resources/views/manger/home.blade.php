<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Al-Based team</title>
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
                    <h1 style="color:white; margin:10px">Al-Based team</h1></a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="header-top-menu">
                        <ul class="nav navbar-nav notika-top-nav">
                        <li class="nav-item dropdown">
                            <a style="padding:20px 20px 20px 5px;" href="#" id="markAsRead" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                              <span> <i class="notika-icon notika-mail"></i></span>
                              @if($unreadMessagesCount == 0)
                                <div class="ntd-ctn"> <span id="unreadCount">{{ $unreadMessagesCount }}</span></div>
                              @else
                                <div class="spinner4 spinner-4"></div><div class="ntd-ctn"> <span id="unreadCount">{{ $unreadMessagesCount }}</span></div>
                              @endif
                            </a>
                         
                            <div role="menu" class="dropdown-menu message-dd animated zoomIn">
                                <div class="hd-mg-tt">
                                    <h2>Chat with Member</h2>
                                </div>
                                <div class="hd-message-info">
                                    @if($user->count() > 0)
                                        @foreach($user as $row)
                                            <a href="{{ route('chat.member', ['id' => $row->id]) }}">
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
                                    <h4 class="text-center">No member yet for chat</h4>
                                        
                                    @endif
                                </div>
                            </div>
                          </li>
                          <li class="nav-item dropdown">
                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span><i class="notika-icon notika-support"></i></span> {{Auth::user()->name}}</a>
                                  <div role="menu" class="dropdown-menu message-dd animated zoomIn">
                                    <div class="hd-message-info">
                                      <a href="{{ route('manger.profile') }}" >
                                            <div class="hd-message-sn" style="text-align:center; display:contents">
                                                    <h3 style="color:black">Update profile</h3>
                                            </div>
                                      </a>
                                        <hr>
                                        
                                      <a href="{{ route('logout') }}"  onclick="event.preventDefault();document.getElementById('logout-form').submit();">
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
                                <li><a data-toggle="collapse" data-target="#Charts" href="{{url('/home')}}">Home</a>
                                   
                                </li>
                                <li><a data-toggle="collapse"  href="{{route('manger.show.group')}}">Management group</a>
               
                                </li>
                
                                <li><a data-toggle="collapse"  href="{{route('manger.show.member')}}">Management members</a>
                                 
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
                        <li><a  href="{{route('manger.show.group')}}"><i class="notika-icon notika-support"></i> Management group</a>
                        </li>
               
                        <li><a  href="{{route('manger.show.member')}}"><i class="notika-icon notika-form"></i> Management members</a>
                        </li>
                     
 
                        </li>
                    </ul>
                    <div class="tab-content custom-menu-content">
                      
                      
                    @yield('content')
                    
      
    <!-- Main Menu area End-->
    <script>
      document.getElementById('markAsRead').addEventListener('click', function(event) 
      {
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
    <script src="{{asset('script.js')}}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="{{asset('js/vendor/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/wow.min.js')}}"></script>
    <script src="{{asset('js/meanmenu/jquery.meanmenu.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
</body>

</html>