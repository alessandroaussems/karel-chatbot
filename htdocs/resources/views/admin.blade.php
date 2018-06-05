@extends('partials.master')

@section('content')
    @include("partials.notify")
    <div class="menu">
        <h3>Welkom! {{Auth::user()->name}}</h3><a href="{{ route('logout') }}">Uitloggen</a>
        <p>Hier kan je de instellingen aanpassen voor Karel-Chatbot:</p>
        <ul class="options">
            @if(Auth::user()->hasRole("admin") )
            <li><a href="/users">Beheerders</a></li>
            @endif
            @if(Auth::user()->hasRole("admin") || Auth::user()->hasRole("editor") )
                <li><a href="/messages">Berichten</a></li>
            @endif
            @if(Auth::user()->hasRole("admin") || Auth::user()->hasRole("editor") )
                <li><a href="/tags">Tags</a></li>
            @endif
            @if(Auth::user()->hasRole("admin") || Auth::user()->hasRole("chatter") )
                <li><a href="/chats">Chats&nbsp;</a><span id="chatnumber">{{ $livechatscount }}</span></li>
            @endif
        </ul>
    </div>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script src="{{asset('js/countlivechats.js')}}"></script>
@endsection
