@extends('partials.master')

@section('content')
                    <form method="POST" action="{{ route('register') }}" class="register">
                        <h3>Admin maken</h3>
                        <small>Deze heeft dan ook toegang tot de opties van Karel!</small>
                        @csrf
                        @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                        <br>
                            <label for="name" class="col-md-4 col-form-label text-md-right">Naam:</label><br>
                            <input id="name" type="text"  name="name" value="{{ old('name') }}" required autofocus><br>

                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail:</label><br>
                            <input id="email" type="email"  name="email" value="{{ old('email') }}" required><br>


                            <label for="password" class="col-md-4 col-form-label text-md-right">Paswoord:</label><br>
                            <input id="password" type="password" name="password" required><br>


                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Paswoord bevestigen:</label><br>
                            <input id="password-confirm" type="password"  name="password_confirmation" required><br>

                                <button type="submit">
                                    Register
                                </button>
                    </form>
@endsection
