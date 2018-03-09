@extends('partials.header')

@section('content')
    <div class="messageform">
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
    <textarea id="example" style="width: 50%; height: 100%"></textarea>
    <script src="{{asset('wysiwyg/sceditor.js')}}"></script>
    <script>
    var textarea = document.getElementById('example');
    sceditor.create(textarea, {
    format: 'bbcode',
    });
    </script>
@endsection