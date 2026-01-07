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

    
<style>
 

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
    background:rgb(74, 141, 195);
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
                        <a href="{{url('/')}}" style="display: flex;">
                            <img  src="{{url('../assets/img/logo.png')}}" alt="" width="50px" height="50px">
                            <h1 style="color:white; margin:10px">TMS</h1>
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="margin-top: 15px;">
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
                                <a  href="#" id="markAsRead" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                    <span> <i class="notika-icon notika-mail"></i></span>
                                
                                </a>
                                    
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
                            <li class="nav-item dropdown">
                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle notification-icon">
                                    <span><i class="notika-icon notika-alarm"></i></span>
                                    @if($unreadMessagesCount == 0)
                                  <div class="ntd-ctn"> <span id="unreadCount">{{ $unreadMessagesCount }}</span></div>
                                    @else
                                    <div class="spinner4 spinner-4"></div><div class="ntd-ctn"> <span id="unreadCount">{{ $unreadMessagesCount }}</span></div>
                                    @endif
                                </a>

                                <div role="menu" style="left:-350px; width:auto !important;" class="dropdown-menu message-dd notification-dd animated zoomIn" style=" width: auto !important;">
                                    <div class="hd-mg-tt">
                                        <h2>Notifications</h2>
                                    </div>


                                    <div class="hd-message-info" id="notification-list" >
                                        @foreach($notifications as $notification)
                                            <a href="{{route('member.show.task')}}" class="notification-item" data-id="{{ $notification->id }}">
                                                <div class="hd-message-sn" style="background-color: {{ $notification->is_read ? '#f1f1f1' : '#fff3cd' }};">
                                                    <div class="hd-mg-ctn">
                                                        <p>{{ $notification->message }}</p>
                                                        <small>{{ $notification->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>


                                    @if($notifications->where('is_read', false)->count() > 0)
                                        <div class="text-center">
                                            <button id="mark-all-read" class="btn btn-primary">Make it read </button>
                                        </div>
                                    @endif                   
                                </div>                     
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span><i class="notika-icon notika-support"></i></span>                                     
                                @if($notifications->where('is_read', false)->count()>0)
                                <div class="spinner4 spinner-4"></div><div class="ntd-ctn"> <span id="notification-count">{{ $notifications->where('is_read', false)->count() }}</span></div>
                                @else
                                <div class="ntd-ctn"> <span id="notification-count">{{ $notifications->where('is_read', false)->count() }}</span></div>
                                @endif
                                {{Auth::user()->name}}</a>
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
                                <li class="{{ Request::is('home') ? 'active' : '' }}"><a data-toggle="collapse"  href="{{url('/home')}}">Home</a>
                                   
                                </li>
                                <li class="{{ Request::is('member/task*') ? 'active' : '' }}"><a data-toggle="collapse" href="{{route('member.show.task')}}">My Tasks</a>
  
                                </li >
                
                                <li class="{{ Request::is('member/skill*') ? 'active' : '' }}"><a data-toggle="collapse"  href="{{route('member.show.skill')}}">Skills</a>
                              
                                </li>
                                <li class="{{ Request::is('member/group*') ? 'active' : '' }}"> <a data-toggle="collapse"  href="{{route('member.show.team')}}">Project team</a>
                         
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
                        <li class="{{ Request::is('home') ? 'active' : '' }}"><a  href="{{url('/home')}}"><i class="notika-icon notika-house"></i> Home</a>
                        </li>
                        <li class="{{ Request::is('member/task*') ? 'active' : '' }}"><a  href="{{route('member.show.task')}}"><i class="notika-icon notika-support"></i> My Tasks</a>
                        </li>
               
                        <li class="{{ Request::is('member/skill*') ? 'active' : '' }}"><a  href="{{route('member.show.skill')}}"><i class="notika-icon notika-form"></i> Skills</a>
                        </li>
                        <li class="{{ Request::is('member/group*') ? 'active' : '' }}"><a  href="{{route('member.show.team')}}"><i class="notika-icon notika-windows"></i> Project team</a>
                        </li>
                        </li>
                    </ul>
                    <div class="tab-content custom-menu-content">                        
                        <div class="form-example-area">
                            <div class="container">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-example-wrap mg-t-30">
                                        <div class="cmp-tb-hd cmp-int-hd">
                                            <h2 class="text-center">Progress tasks</h2>
                                        </div>
                                        <div class="hd-message-info hd-task-info">
                                            @if($task->count()>0)
                                                    <div class="skill">
                                                    @foreach($task as $row)
                                                        <div class="progress">
                                                            <div class="lead-content">
                                                                <p>Name task :{{$row->task_name}} // <span style="color:green">Name manger : {{$row->team->manger->name}}</span> // <span style="color:grey">Name project : {{$row->team->project_name}}</span> </p>
                                                            </div>                            
                                                            <div class="progress-bar wow fadeInLeft" data-progress="{{$row->progress}}" style="width: {{$row->progress}}%;" data-wow-duration="1.5s" data-wow-delay="1.2s"> <span>{{$row->progress}}%</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    </div>
                                            @else
                                            <h4>No tasks yet</h4>
                                            @endif
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
    <script>
      document.getElementById('markAsRead').addEventListener('click', function(event) {
        
                  // تحويل العدد إلى صفر
                  document.getElementById('unreadCount').textContent = 0;
            
      });
    </script> 
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
    <script>
        $(document).ready(function() {
            $('select').select2({
                placeholder: "Select a skill",
                allowClear: true
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // ✅ عند النقر على زر "تحديد الكل كمقروء"
            document.getElementById("mark-all-read")?.addEventListener("click", function () {
                fetch("/member/notifications/mark-all-read")
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelectorAll(".notification-item").forEach(el => {
                                el.style.backgroundColor = "#f1f1f1"; // تغيير اللون
                            });
                            document.getElementById("notification-count").textContent = "0"; // تصفير العدد
                            this.remove(); // إخفاء الزر
                        }
                    });
            });
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