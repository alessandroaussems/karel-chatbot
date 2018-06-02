@extends('partials.master')

@section('content')
    <div class="menu">
        <a class="add" href="/register">n</a><br>
        <h3>Gebruikers</h3>
        <small>Dit zijn alle gebruikers van Karel</small>
        <table border="1">
            <tr><th>Naam</th><th>Email</th><th>Role</th><th>Acties</th></tr>
            @foreach($users as $key => $value)
            <tr><td>{{$value->name}}</td><td>{{$value->email}}</td><td>{{$value->role}}</td>
            <td><a class="edit" href="/users/{{$value->id}}/edit">3</a>
                <a class="delete" href="/users/{{$value->id}}/delete">n</a>
            </td>
            </tr>
            @endforeach
        </table>
    </div>
    {{ $users->links() }}
@endsection