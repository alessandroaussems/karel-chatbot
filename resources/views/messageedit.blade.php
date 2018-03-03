@extends('partials.header')

@section('content')
    <div class="messageedit">
        <h3>Antwoord aanpassen</h3>
        <small>Hier kan je het antwoord van Karel aanpassen.</small>
        {{ Html::ul($errors->all(), array('class' => 'errors'))}}

        {{ Form::model($message, array('route' => array('messages.update', $message->id), 'method' => 'PUT')) }}
        {{ csrf_field() }}

        {{ Form::text('answer', null, array('class' => 'form-control')) }}
        <br>

        {{ Form::button('Antwoord aanpassen!', array('type' => 'submit')) }}

        {{ Form::close() }}

    </div>
@endsection