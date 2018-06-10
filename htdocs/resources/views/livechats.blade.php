@extends('partials.master')
@section('content')
    @include("partials.notify")
    <div class="menu">
        <h3>Livechats</h3>
        <small>Een overzicht van alle chats die een medewerker antwoord nodig hebben.</small>
        <ul class="options">
            @foreach($livechats_pag as $livechat => $value)
                <li><a href="/livechat/{{$value->session_id}}">{{$value->session_id}}</a></li>
            @endforeach
        </ul>
    </div>
    {{ $livechats_pag->links() }}
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script src="{{asset('js/listenfornewchatrequests.js')}}"></script>
    <script src="{{asset('js/adminheartbleed.js')}}"></script>
@endsection
