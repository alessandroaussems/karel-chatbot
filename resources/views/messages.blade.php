@extends('partials.header')

@section('content')
        <ul id="messages">
            @foreach($messages as $key => $value)
                <li>
                    {{$value->answer}}
                </li>
            @endforeach
        </ul>
@endsection