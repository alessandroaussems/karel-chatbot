@extends('partials.master')

@section('content')
    <div class="edituserheader">
        <h3>Gebruiker aanpassen</h3>
        <small>Deze kan Karel dan mee instellen!</small><br>
        <small id="important">*Opmerking: Omwille van veiligheidsredenen is het niet toegestaan om het paswoord te wijzigen</small>
        {{ Html::ul($errors->all(), array('class' => 'errors'))}}
    </div>

            {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT',"class"=>"useredit")) }}
            {{ csrf_field() }}
            {{Form::label('name', 'Naam:')}}
            {{ Form::text('name', null, ['class' => 'field']) }}
            {{Form::label('email', 'E-mail:')}}
            {{ Form::email('email', null, ['class' => 'field']) }}
            {{Form::label('role', 'Rol:')}}
            {{ Form::select('role', array('admin' => 'Admin', 'editor' => 'Editor', 'chatter' => 'Chatter'),null, ['class' => 'field']) }}
        <br>

        {{ Form::button('Gebruiker aanpassen!', array('type' => 'submit')) }}

        {{ Form::close() }}
@endsection
