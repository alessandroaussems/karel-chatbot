@extends('partials.header')

@section('content')

                    <form method="POST" action="{{ route('login') }}" class="login">
                        @csrf

                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong><br>
                                    </span>
                        @endif
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong><br>
                                    </span>
                        @endif 
                            <label for="email">E-Mail:</label><br>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus><br>


                            <label for="password">Paswoord:</label><br>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required><br>



                                <button type="submit">
                                    Login
                                </button>
                    </form>
@endsection
