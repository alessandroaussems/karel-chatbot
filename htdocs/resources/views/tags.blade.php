@extends('partials.header')

@section('content')
    <div class="tagsoverview">
        <h3>Tags</h3>
        <small>Dit zijn alle tags die je in een antwoord kan gebruiken om live data van het intranet te halen!</small>
        <ul id="tags">
            @foreach($tags as $key => $value)
                <li>
                    [intranet]{{ $value->tag }}[/intranet]
                </li>
            @endforeach
        </ul>
    </div>
@endsection