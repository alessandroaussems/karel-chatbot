@extends('partials.header')

@section('content')
    <div class="messageform">
        <h3>Zin aanpassen!</h3>
        <small>Hier kan je de zin waarop Karel zal reageren aanpassen!</small>
        {{ Html::ul($errors->all(), array('class' => 'errors'))}}

        {{ Form::model($sentence, array('route' => array('sentences.update', $sentence->id), 'method' => 'PUT')) }}
        {{ csrf_field() }}
        {{ Form::hidden('messageid', $messageid) }}

        {{ Form::text('sentence', null, array('class' => 'form-control')) }}
        <br>

        {{ Form::button('Zin aanpassen!', array('type' => 'submit')) }}

        {{ Form::close() }}

    </div>
@endsection