@extends('partials.master')

@section('content')
    <div class="menu">
        <a class="add" href="/register">n</a><br>
        <h3>Beheerders</h3>
        <small>Dit zijn alle beheerders van Karel-Chatbot</small>
        <table border="1">
            <tr><th>Naam</th><th>Email</th><th>Rol</th><th>Acties</th></tr>
            @foreach($users as $key => $value)
            <tr><td>{{$value->name}}</td><td>{{$value->email}}</td><td>{{ ucfirst($value->role) }}</td>
            <td><a class="edit" href="/users/{{$value->id}}/edit">3</a>
                <a class="delete" href="/users/{{$value->id}}/delete">n</a>
            </td>
            </tr>
            @endforeach
        </table>
    </div>
    {{ $users->links() }}
    <script src="{{asset('js/adminheartbleed.js')}}"></script>
@endsection