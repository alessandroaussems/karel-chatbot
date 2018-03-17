@extends('partials.header')

@section('content')
    <div class="chat">
        <ul id="messagelist">
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
<script src="{{asset('js/main.js')}}"></script>
@endsection