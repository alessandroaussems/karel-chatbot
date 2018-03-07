@extends('partials.header')

@section('content')
    <div class="chat">
        <ul id="messagelist">
            <li class="botmessage">Hallo! Ik ben Karel! Dé chatbot van KdG! Heb je vragen? Stel ze maar!</li>
            <li class="usermessage">Hier komen berichten van de gebruiker!</li>
        </ul>
    </div>
    <input type="text" class="userinput" placeholder="Typ je bericht hier..." onkeypress="sendMessage(this.value,event)" autofocus>
<script src="{{asset('js/main.js')}}"></script>
@endsection