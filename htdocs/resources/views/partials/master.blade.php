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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sceditor/2.1.3/themes/modern.min.css">
</head>
<body>
@extends("partials.overlay")
<nav class="clearfix">
    <a id="settings" href="/admin">k</a>
    <a href="/" id="botlogo">
    <img src="{{asset('img/logo_white.png')}}" alt="Logo van Karel - Chatbot" title="Logo van Karel - Chatbot">
    </a>
    <h1>Karel - Chatbot</h1>
    <a href="https://www.kdg.be/" id="kdglogo" target="_blank">
    <img  src="{{asset('img/logo_kdg_white.png')}}" alt="Logo van KdG" title="Logo van KdG">
    </a>
</nav>
<main>
    @yield('content')
</main>
</body>
</html>
