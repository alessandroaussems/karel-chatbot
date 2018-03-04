@extends('partials.header')

@section('content')
    <div class="messagedetail">
        <h3>Bericht</h3>
        <small>Hier zie je wat Karel antwoord op bepaalde berichten</small>
        <h5>Antwoord:</h5>
        <p class="answer">{{$message->answer}}</p>
        <a class="edit" href="/messages/{{$message->id}}/edit">3</a>
        <a class="delete" href="/messages/{{$message->id}}/delete">n</a>
        <h5>Reageert op:</h5>
        <ul>
            @foreach($answers as $key => $value)
                <li>
                    {{$value->sentence}}
                </li>
            @endforeach
        </ul>
    </div>
@endsection