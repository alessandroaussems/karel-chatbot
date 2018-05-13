@extends('partials.master')

@section('content')
    <form method="POST" action="{{ route('password.email') }}" class="email">
        <h3>Wachtwoord vergeten</h3>
        <small>Vul hier je email in en je ontvangt een herstellink!</small>
        @csrf
        @if ($errors->has('email'))
            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
        @endif
        <br>

        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail:</label><br>
        <input id="email" type="email"  name="email" value="{{ old('email') }}" required><br>

        <button type="submit">
            Herstel link sturen
        </button>
    </form>
@endsection