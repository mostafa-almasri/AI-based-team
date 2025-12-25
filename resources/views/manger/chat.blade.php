
@extends('manger.home')

@section('content')

<div class="form-example-area">
        <div class="container">
  
            <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">

<ul class="chat-thread" id="chatThread">
@foreach($messages as $index => $message)
    @php
        $isSameSender = ($index > 0 && $messages[$index - 1]->sender_id == $message->sender_id);
        $isMine = $message->sender_id == Auth::id();
    @endphp

    <li class="{{ $isMine ? 'sent' : 'received' }}">
        {{-- إذا لم تكن رسالة من نفس المرسل فأعرض الصورة --}}
        @if(!$isSameSender)
            @php
                $avatar = $message->sender->image;
                $avatarUrl = $avatar ? asset('uploads/profile/'.$avatar) : asset('profile.png');
                $alt = $message->sender->name ?? 'User';
            @endphp
            <img src="{{ $avatarUrl }}" alt="{{ $alt }}" class="avatar">
        @else
            {{-- بدّل هذا العنصر حسب التصميم: يمكن تركه فارغًا للمحاذاة أو لا تضع شيئًا --}}
            <div class="avatar-spacer"></div>
        @endif

        <div class="message-body">
            <span class="message-text">{{ $message->message }}</span><br>
            <span class="message-time">{{ $message->sent_at }}</span>
        </div>
    </li>
@endforeach
</ul>
<form class="chat-window" id="chatWindow" >
    <input class="chat-window-message" id="chatMessage" name="chat-window-message" type="text" autocomplete="off" autofocus />
</form>



</div>
            </div>
            
        </div>
    </div>
    <script>
    const receiverId = {{ $id }}; // معرف المستخدم الذي تتحدث إليه
</script>
@endsection