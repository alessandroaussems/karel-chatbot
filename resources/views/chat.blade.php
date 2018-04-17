@extends('partials.header')
@section('content')
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
            <!--<li class="botmessage">Hallo! Ik ben Karel! Dé chatbot van KdG! Heb je vragen? Stel ze maar!</li>
            <li class="usermessage">Hier komen berichten van de gebruiker!</li>-->
        </ul>
        <div class="opener">
            <img src="{{asset("img/logo_black.png")}}" alt="Logo van Karel-Chatbot" title="Logo van Karel-Chatbot">
            <h2>Karel - Chatbot</h2>
            <p>Karel dé chatbot van KdG, voor al je vragen!</p>
        </div>
    </div>
    <input type="text" class="userinput" placeholder="Typ je bericht hier..." onkeypress="sendMessage(this.value,event)" autofocus>
    <span id="send" onclick="sendMessage('getit',event)"> > </span>
<script src="{{asset('js/main.js')}}"></script>
@endsection