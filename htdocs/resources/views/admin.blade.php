@extends('partials.master')

@section('content')
    <div class="menu">
        <h3>Welkom! {{Auth::user()->name}}</h3>    <a href="{{ route('logout') }}"> Logout </a>
        <p>Hier kan je de instellingen aanpassen voor Karel-Chatbot:</p>
        <ul class="options">
            @if(Auth::user()->hasRole("admin") )
            <li><a href="/register">Gebruiker maken</a></li>
            @endif
            @if(Auth::user()->hasRole("admin") || Auth::user()->hasRole("editor") )
                <li><a href="/messages">Berichten</a></li>
            @endif
            @if(Auth::user()->hasRole("admin") || Auth::user()->hasRole("editor") )
                <li><a href="/tags">Tags</a></li>
            @endif
            @if(Auth::user()->hasRole("admin") || Auth::user()->hasRole("chatter") )
                <li><a href="/chats">Chats</a></li>
            @endif
        </ul>
    </div>

@endsection
