<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    @yield('content')
</main>
</body>
</html>
