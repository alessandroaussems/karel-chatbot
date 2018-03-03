@extends('partials.header')

@section('content')
    <div class="adminmenu">
        <h3>Welkom! {{Auth::user()->name}}</h3>    <a href="{{ route('logout') }}"> Logout </a>
        <p>Hier kan je de instellingen aanpassen voor Karel-Chatbot:</p>
        <ul class="options">
            <li><a href="/register">Admin bijmaken</a></li>
        </ul>
    </div>

@endsection
