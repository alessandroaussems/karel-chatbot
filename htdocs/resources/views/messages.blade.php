@extends('partials.master')

@section('content')
    <div class="menu">
        <a class="add" href="messages/create">n</a><br>
        <h3>Berichten</h3>
        <small>Dit zijn alle antwoorden die Karel kan geven! Klik op eentje om meer opties te krijgen!</small>
        <ul class="options">
            @foreach($messages as $key => $value)
                <li>
                    <a href="/messages/{{$value->id}}">{{ substr(html_entity_decode(strip_tags($value->answer)), 0, 50)}}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection