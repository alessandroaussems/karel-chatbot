@extends('partials.master')

@section('content')
    <div class="messageform">
        <h3>Bericht bewerken</h3>
        <small>Hier kan je het antwoord van Karel-Chatbot aanpassen.</small>
        {{ Html::ul($errors->all(), array('class' => 'errors'))}}

        {{ Form::model($message, array('route' => array('messages.update', $message->id), 'method' => 'PUT')) }}
        {{ csrf_field() }}

        {{ Form::textarea('answer', null, ['class' => 'field']) }}
        <br>

        {{ Form::button('Bericht bewerken', array('type' => 'submit')) }}

        {{ Form::close() }}

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sceditor/2.1.3/sceditor.min.js"></script>
    <script>
    var textarea = document.getElementsByClassName('field')[0];
    sceditor.create(textarea, {
    format: 'bbcode',
    emoticonsRoot: window.location.origin+"/img/"
    });
    sceditor.instance(textarea).css('body { font-family: Verdana }');
    </script>
    <script src="{{asset('js/adminheartbleed.js')}}"></script>
@endsection