@extends('partials.master')
@section('content')
    <div class="livechat">
        <ul id="messagelist">
            @foreach($messages as $key => $value)
                @if($value[1]=="H")
                    <li class="botmessage"><?php echo $value[0] ?></li>
                @endif
                @if($value[1]=="B")
                    <li class="usermessage"><?php echo $value[0] ?></li>
            @endif
        @endforeach
        </ul>
    </div>
    <input type="text" class="userinput" placeholder="Typ je bericht hier..." onkeypress="sendMessage(this.value,event)" autofocus>
    <span id="send" onclick="sendMessage('getit',event)"> > </span>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script src="{{asset('js/livechat.js')}}"></script>
    <script src="{{asset('js/adminheartbleed.js')}}"></script>
@endsection