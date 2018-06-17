@extends('partials.master')

@section('content')
    <div class="messagedetail">
        <h3>Bericht detail</h3>
        <small>Hier zie je wat Karel-Chatbot antwoord op bepaalde berichten</small>
        <h5>Antwoord:</h5>
        <div class="icons">
        <a class="edit" href="/messages/{{$message->id}}/edit">3</a>
        <a class="delete" href="/messages/{{$message->id}}/delete">n</a>
        </div>
        <div class="answer"><?php echo $message->answer?></div>
        <h5>Sleutelwoorden:</h5>
        <ul>
            @foreach($keywords as $key => $value)
                <li>
                    {{$value->keyword}}
                </li>
                <a class="edit" href="/keywords/edit/{{$value->id}}/message/{{$message->id}}">3</a>
                <a class="delete" href="/keywords/{{$value->id}}/delete/message/{{$message->id}}">n</a>
                <br>
            @endforeach
        </ul>
        <a class="add" href="/keywords/create/{{$message->id}}">n</a><br>
    </div>
    <script src="{{asset('js/adminheartbleed.js')}}"></script>
@endsection