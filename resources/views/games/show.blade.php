@extends('layouts.app')

@section('content')

<div class="container">
    <h2> {{$game->name}} </h2>
    <img src="{{ asset('images/gamedefault.png') }}" class="img-responsive mx-auto d-block rounded" width="460" height="215px">
    <br>
    <a href="">Add a game image</a><br>
    <br>
    <p> {{$game->description}} </p>

    <table class="table">

        @if(count($keys) > 0)
            <tr>
                <th>Platform</th>
                <th>Added By</th>
            </tr>
            @foreach($keys as $key)
                <tr>
                <td>
                    <a href="/keys/{{$key->id}}">{{$key->platform}}</a>
                </td>
                    <td><a href="/users/{{$key->created_user_id}}">{{$key->created_user_name}}</a></td>
                <tr>
            @endforeach
        @else
            <p> No Keys Available <p>
        @endif

</div>
@endsection
