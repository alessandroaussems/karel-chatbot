@extends('partials.master')

@section('content')
    <div class="edituserheader">
        <h3>Notificatie voorkeuren</h3>
        <small>Hier kan je je notificatievoorkeuren voor Karel-Chatbot aanpassen.</small><br>
    {{ Html::ul($errors->all(), array('class' => 'errors'))}}
        @if(session('success'))
            <p id="succes">{{session('success')}}</p>
        @endif
    </div>
    {{ Form::model($session, array('route' => array('notifications.update', $id), 'method' => 'PUT',"class"=>"notificationedit")) }}
    {{ csrf_field() }}
    {{Form::label('sendmail', 'E-mail meldingen:')}}
    {{ Form::select('sendmail', array('1' => 'Ja', '0' => 'Nee'),null, ['class' => 'field']) }}
    {{Form::label('sendsms', 'Sms meldingen:')}}
    {{ Form::select('sendsms', array('1' => 'Ja', '0' => 'Nee'),null, ['class' => 'field']) }}
    <br>

    {{ Form::button('Voorkeuren aanpassen.', array('type' => 'submit')) }}

    {{ Form::close() }}
@endsection
