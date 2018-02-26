<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}  - Chatbot</title>
    <link rel="icon" type="image/png" href="{{asset('img/logo_black.png')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('styling/main.css')}}">
</head>
<body>
<nav class="clearfix">
    <img id="botlogo" src="{{asset('img/logo_white.png')}}">
    <h1>Karel - Chatbot</h1>
    <img id="kdglogo" src="{{asset('img/logo_kdg_white.png')}}">
</nav>
<main>
    <div class="chat">
        <ul id="messagelist">
            <li class="botmessage">Hallo! Ik ben Karel! Dé chatbot van KdG! Heb je vragen? Stel ze maar!</li>
            <li class="usermessage">Hier komen berichten van de gebruiker!</li>
        </ul>
    </div>
    <input type="text" class="userinput" placeholder="Typ je bericht hier..." onkeydown="sendMessage(this)">
</main>
<script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
</body>
</html>
