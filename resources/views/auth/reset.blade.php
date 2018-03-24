@extends('partials.header')

@section('content')
                        <form class="reset" method="POST" action="{{ route('password.request') }}">
                            {{ csrf_field() }}
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                            @endif

                            <input type="hidden" name="token" value="{{ $token }}">
                            <label for="email">E-Mail:</label><br>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus><br>


                            <label for="password">Wachtwoord:</label><br>
                            <input id="password" type="password"  name="password" required><br>

                            <label for="password-confirm">Wachtwoord bevestigen:</label><br>
                            <input id="password-confirm" type="password"  name="password-confirm" required><br>

                            <button type="submit">
                                Wachtwoord herstellen
                            </button>

@endsection