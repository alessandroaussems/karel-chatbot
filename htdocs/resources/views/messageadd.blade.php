@extends('partials.master')

@section('content')
    <div class="messageform">
        <h3>Bericht toevoegen</h3>
        <small>Hier kan je een antwoord van Karel-Chatbot toevoegen.</small>
        {{ Html::ul($errors->all(), array('class' => 'errors'))}}

        {{ Form::open(['url' => 'messages'])}}

        {{ csrf_field() }}

        {{ Form::textarea('answer', null, ['class' => 'field']) }}
        <br>

        {{ Form::button('Bericht toevoegen', array('type' => 'submit')) }}

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