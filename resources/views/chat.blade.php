<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}  - Chatbot</title>
    <link rel="stylesheet" type="text/css" href="{{asset('styling/main.css')}}">
</head>
<body>
<nav>
    <img src="{{asset('img/logo_white.png')}}">
</nav>
<main>
    <div class="chat">
        <ul id="messagelist">
            <li class="botmessage">Bot</li>
            <li class="usermessage">Me</li>
        </ul>
    </div>
    <input type="text" class="userinput" onkeydown="sendMessage(this)">
</main>
<script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
</body>
</html>
