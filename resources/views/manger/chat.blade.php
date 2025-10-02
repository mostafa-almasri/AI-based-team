
@extends('manger.home')

@section('content')

<div class="form-example-area">
        <div class="container">
  
            <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">

<ul class="chat-thread" id="chatThread">
    @foreach($messages as $index => $message)

        @php
            // تحقق مما إذا كانت الرسالة الحالية من نفس المرسل مثل الرسالة السابقة
            $isSameSender = ($index > 0 && $messages[$index - 1]->sender_id == $message->sender_id);
        @endphp
        <li class="{{ $message->sender_id == Auth::user()->id ? 'sent' : 'received' }}">
            @if(!$isSameSender)
                <img class="avatar" src="{{ asset('profile.png') }}" alt="User Avatar" />
            @endif
            <div>
            <span class="message-text">{{ $message->message }}</span> <br>
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