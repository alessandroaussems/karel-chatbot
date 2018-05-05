@extends('partials.header')

@section('content')
    <div class="messageform">
        <h3>Zin toevoegen!</h3>
        <small>Hier kan je een zin toevoegen waarop Karel zal reageren.</small>
        {{ Html::ul($errors->all(), array('class' => 'errors'))}}

        {{ Form::open(['url' => 'sentences'])}}
        {{ csrf_field() }}

        {{ Form::hidden('messageid', $messageid) }}
        {{ Form::text('sentence', null, array('class' => 'form-control')) }}
        <br>

        {{ Form::button('Zin toevoegen!', array('type' => 'submit')) }}

        {{ Form::close() }}

    </div>
@endsection