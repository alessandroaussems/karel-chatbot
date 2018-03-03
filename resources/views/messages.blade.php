@extends('partials.header')

@section('content')
    <div class="messagesoverview">
        <h3>Berichten</h3>
        <small>Dit zijn alle antwoorden die Karel kan geven! Klik op eentje om meer opties te krijgen!</small>
        <ul id="messages">
            @foreach($messages as $key => $value)
                <li>
                    <a href="/messages/{{$value->id}}">{{ substr($value->answer, 0, 50)}}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection