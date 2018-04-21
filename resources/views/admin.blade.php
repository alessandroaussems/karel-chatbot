@extends('partials.header')

@section('content')
    <div class="adminmenu">
        <h3>Welkom! {{Auth::user()->name}}</h3>    <a href="{{ route('logout') }}"> Logout </a>
        <p>Hier kan je de instellingen aanpassen voor Karel-Chatbot:</p>
        <ul class="options">
            <li><a href="/register">Admin maken</a></li>
            <li><a href="/messages">Berichten</a></li>
            <li><a href="/tags">Tags</a></li>
        </ul>
    </div>

@endsection
