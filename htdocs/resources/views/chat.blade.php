@extends('partials.master')
@section('content')
    @include("partials.help")
    @include("partials.cookie")
    <div class="chat">
        <ul id="messagelist">
            @foreach($messages as $key => $value)
                @if($value[1]=="B")
                    <li class="botmessage"><?php echo $value[0] ?></li>
                @endif
                @if($value[1]=="H")
                    <li class="usermessage"><?php echo $value[0] ?></li>
                @endif
        @endforeach
        </ul>
        <div class="opener">
            <img src="{{asset("img/logo_black.png")}}" alt="Logo van Karel-Chatbot" title="Logo van Karel-Chatbot">
            <h2>Karel - Chatbot</h2>
            <p>Dé chatbot van KdG</p>
        </div>
    </div>
    <input type="text" class="userinput" placeholder="Typ je bericht hier..." onkeypress="sendMessage(this.value,event)" autofocus>
    @if(isset($isconnected))
        @if(!$isconnected)
            <span id="kdgconnect" onclick="showLoginForm(this.event)">h</span>
        @endif
    @endif
    <span id="send" onclick="sendMessage('getit',event)"> > </span>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script src="{{asset('js/chat.js')}}"></script>
    <script src="{{asset('js/heartbleed.js')}}"></script>
    <script src="{{asset('js/help.js')}}"></script>
    <script src="{{asset('js/cookie.js')}}"></script>
@endsection