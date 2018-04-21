@extends('partials.header')

@section('content')
    <div class="tagsoverview">
        <h3>Tags</h3>
        <small>Dit zijn alle mogelijke tags die je kan gebruiken om iets live van Intranet te halen.</small>
        <ul id="tags">
            @foreach($tags as $key =>$value)
                <li>
                    <h5>{{$value}}</h5>
                    <p>{{$explanations[$key]}}</p>
                </li>
            @endforeach
        </ul>
    </div>
@endsection