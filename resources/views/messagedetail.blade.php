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
                <a class="edit" href="/sentences/edit/{{$value->id}}/message/{{$message->id}}">3</a>
                <a class="delete" href="/messages/{{$value->id}}/delete">n</a>
                <br>
            @endforeach
        </ul>
        <a class="add" href="/sentences/create/{{$message->id}}">n</a><br>
    </div>
@endsection