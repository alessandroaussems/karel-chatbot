@extends('layouts.header')

@section('content')
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label><br>
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus><br>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif

                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label><br>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required><br>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label><br>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required><br>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label><br>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required><br>

                                <button type="submit">
                                    Register
                                </button>
                    </form>
@endsection
