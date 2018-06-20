<!doctype html>
<html lang="{{ app()->getLocale() }}" class="route-{{ Route::currentRouteName() }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-90024711-6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-90024711-6');
    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-title" content="Karel-Chatbot" />
    <meta name="apple-mobile-web-app-status-bar-style" content="white" />
    <link rel="apple-touch-icon" href="{{asset('img/appicon.png')}}">

    <meta name="description" content="Dé chatbot van KdG" />
    <meta name="title" content="Karel-Chatbot">
    <meta name="locale" content="nl">
    <meta name="keywords" content="KdG,Karel De Grote Hogeschool,Chatbot,Karel-Chatbot,Karel,Hogeschool">
    <meta name="author" content="Alessandro Aussems">
    <meta name="publisher" content="Alessandro Aussems">
    <meta name="robots" content="all">
    <link rel="canonical" href="https://karel-chatbot.be">

    <meta property="og:title" content="Karel-Chatbot" />
    <meta property="og:site_name" content="Karel-Chatbot" />
    <meta property="og:description" content="Dé chatbot van KdG" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{asset('img/ogimage.png')}}" />

    <title>{{ config('app.name') }}
        @if(isset($pagetitle))
            | {{$pagetitle}}
        @endif
    </title>

    <link rel="icon" type="image/png" href="{{asset('img/logo_black.png')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('styling/main.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sceditor/2.1.3/themes/modern.min.css">
</head>
<body class="route-{{ Route::currentRouteName() }}">
@extends("partials.overlay")
<nav class="clearfix">
    @if(Auth::check() && Route::currentRouteName()!="home")
    <a href="/admin" id="botlogo" title="Karel-Chatbot">
    @else
    <a href="/" id="botlogo" title="Karel-Chatbot">
    @endif
    <img src="{{asset('img/logo_white.png')}}" alt="Logo van Karel - Chatbot" title="Logo van Karel - Chatbot">
    </a>
    <h1>Karel - Chatbot</h1>
    <a href="https://www.kdg.be/" id="kdglogo" target="_blank" title="Karel De Grote Hogeschool">
    <img  src="{{asset('img/logo_kdg_white.png')}}" alt="Logo van KdG" title="Logo van KdG">
    </a>
</nav>
<main>
    @yield('content')
</main>
</body>
</html>
