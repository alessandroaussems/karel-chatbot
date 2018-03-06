@extends('partials.header')

@section('content')
    <div class="messageform">
        <h3>Antwoord toevoegen</h3>
        <small>Hier kan je een antwoord van Karel toevoegen</small>
        {{ Html::ul($errors->all(), array('class' => 'errors'))}}

        {{ Form::open(['url' => 'messages'])}}
        {{ csrf_field() }}

        {{ Form::text('answer', null, array('class' => 'form-control')) }}
        <br>

        {{ Form::button('Antwoord toevoegen!', array('type' => 'submit')) }}

        {{ Form::close() }}

    </div>
@endsection