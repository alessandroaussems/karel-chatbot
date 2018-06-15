@extends('partials.master')

@section('content')
    <div class="messageform">
        <h3>Sleutelwoord toevoegen!</h3>
        <small>Hier kan je een sleutelwoord toevoegen waarop Karel-Chatbot zal reageren.</small>
        {{ Html::ul($errors->all(), array('class' => 'errors'))}}

        {{ Form::open(['url' => 'keywords'])}}
        {{ csrf_field() }}

        {{ Form::hidden('messageid', $messageid) }}
        {{ Form::text('keyword', null, array('class' => 'form-control')) }}
        <br>

        {{ Form::button('Sleutelwoord toevoegen', array('type' => 'submit')) }}

        {{ Form::close() }}

    </div>
    <script src="{{asset('js/adminheartbleed.js')}}"></script>
@endsection