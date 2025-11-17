
@extends('member.home')

@section('notifi')
<li class="nav-item nc-al"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span><i class="notika-icon notika-alarm"></i></span><div class="spinner4 spinner-4"></div><div class="ntd-ctn"><span>3</span></div></a>
                                <div role="menu" class="dropdown-menu message-dd notification-dd animated zoomIn">
                                    <div class="hd-mg-tt">
                                        <h2>Notification</h2>
                                    </div>
                                    <div class="hd-message-info">
                                        <a href="#">
                                            <div class="hd-message-sn">
                                                <div class="hd-message-img">
                                                    <img src="img/post/1.jpg" alt="" />
                                                </div>
                                                <div class="hd-mg-ctn">
                                                    <h3>David Belle</h3>
                                                    <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="hd-message-sn">
                                                <div class="hd-message-img">
                                                    <img src="img/post/2.jpg" alt="" />
                                                </div>
                                                <div class="hd-mg-ctn">
                                                    <h3>Jonathan Morris</h3>
                                                    <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="hd-message-sn">
                                                <div class="hd-message-img">
                                                    <img src="img/post/4.jpg" alt="" />
                                                </div>
                                                <div class="hd-mg-ctn">
                                                    <h3>Fredric Mitchell</h3>
                                                    <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="hd-message-sn">
                                                <div class="hd-message-img">
                                                    <img src="img/post/1.jpg" alt="" />
                                                </div>
                                                <div class="hd-mg-ctn">
                                                    <h3>David Belle</h3>
                                                    <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="hd-message-sn">
                                                <div class="hd-message-img">
                                                    <img src="img/post/2.jpg" alt="" />
                                                </div>
                                                <div class="hd-mg-ctn">
                                                    <h3>Glenn Jecobs</h3>
                                                    <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="hd-mg-va">
                                        <a href="#">View All</a>
                                    </div>
                                </div>
                            </li>
<li class="nav-item dropdown">
                            <a style="padding:20px 20px 20px 5px;" href="#" id="markAsRead" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                <span> <i class="notika-icon notika-mail"></i></span>
                                <!-- @if($unreadMessagesCount == 0)
                              <div class="ntd-ctn"> <span id="unreadCount">{{ $unreadMessagesCount }}</span></div>
                                @else
                                <div class="spinner4 spinner-4"></div><div class="ntd-ctn"> <span id="unreadCount">{{ $unreadMessagesCount }}</span></div>
                                @endif -->
                            </a>
                            <script>
                            document.getElementById('markAsRead').addEventListener('click', function(event) {
                                event.preventDefault(); // منع إعادة التحميل

                                fetch("{{ route('notifications.read') }}", {
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
            <h2>Notifications</h2>
        </div>
        <div class="hd-message-info">
        <ul>
        @foreach($notifications as $notification)
            <li style="{{ $notification->is_read ? 'color: gray;' : 'font-weight: bold;' }}">
                {{ $notification->message }}
                @if(!$notification->is_read)
                    <a href="{{ route('notifications.read', $notification->id) }}">تحديد كمقروء</a>
                @endif
            </li>
        @endforeach
    </ul>
         
        </div>
    </div>
</li>
@endsection