@extends('partials.header')

@section('content')
    <div class="messagedetail">
        <h3>Bericht</h3>
        <small>Hier zie je wat Karel antwoord op bepaalde berichten</small>
        <h5>Antwoord:</h5>
        <p>{{$message->answer}}</p>
        <a href="/messages/{{$message->id}}/edit">Edit</a>
        {{ Form::open(array('url' => 'messages/' . $message->id, 'class' =>'delete')) }}
        {{ Form::hidden('_method', 'DELETE') }}
        {{ Form::submit('Delete', array('class' => 'delete','onclick'=>'return confirm("Ben je zeker?")')) }}
        {{ Form::close() }}
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