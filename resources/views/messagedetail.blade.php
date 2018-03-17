@extends('partials.header')

@section('content')
    <div class="messagedetail">
        <h3>Bericht</h3>
        <small>Hier zie je wat Karel antwoord op bepaalde berichten</small>
        <h5>Antwoord:</h5>
        <a class="edit pullright" href="/messages/{{$message->id}}/edit">3</a>
        <a class="delete" href="/messages/{{$message->id}}/delete">n</a>
        <div class="answer"><?php echo $message->answer?></div>
        <h5>Reageert op:</h5>
        <ul>
            @foreach($answers as $key => $value)
                <li>
                    {{$value->sentence}}
                </li>
                <a class="edit" href="/sentences/edit/{{$value->id}}/message/{{$message->id}}">3</a>
                <a class="delete" href="/sentences/{{$value->id}}/delete/message/{{$message->id}}">n</a>
                <br>
            @endforeach
        </ul>
        <a class="add" href="/sentences/create/{{$message->id}}">n</a><br>
    </div>
@endsection