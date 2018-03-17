@extends('partials.header')

@section('content')
    <div class="messageform">
        <h3>Antwoord toevoegen</h3>
        <small>Hier kan je een antwoord van Karel toevoegen</small>
        {{ Html::ul($errors->all(), array('class' => 'errors'))}}

        {{ Form::open(['url' => 'messages'])}}

        {{ csrf_field() }}

        {{ Form::textarea('answer', null, ['class' => 'field']) }}
        <br>

        {{ Form::button('Antwoord aanpassen!', array('type' => 'submit')) }}

        {{ Form::close() }}

    </div>
    <script src="{{asset('wysiwyg/sceditor.js')}}"></script>
    <script>
        var textarea = document.getElementsByClassName('field')[0];
        sceditor.create(textarea, {
            format: 'bbcode',
        });
    </script>
@endsection