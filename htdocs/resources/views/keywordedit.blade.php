@extends('partials.master')

@section('content')
    <div class="messageform">
        <h3>Sleutelwoord bewerken</h3>
        <small>Hier kan je het sleutelwoord waarop Karel-Chatbot zal reageren aanpassen!</small>
        {{ Html::ul($errors->all(), array('class' => 'errors'))}}

        {{ Form::model($keyword, array('route' => array('keywords.update', $keyword->id), 'method' => 'PUT')) }}
        {{ csrf_field() }}
        {{ Form::hidden('messageid', $messageid) }}

        {{ Form::text('keyword', null, array('class' => 'form-control')) }}
        <br>

        {{ Form::button('Sleutelwoord bewerken', array('type' => 'submit')) }}

        {{ Form::close() }}

    </div>
    <script src="{{asset('js/adminheartbleed.js')}}"></script>
@endsection