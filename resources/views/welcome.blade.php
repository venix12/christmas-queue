@extends('main')

@section('content')
    <div id="navbar" current='Home'></div>
    <h1 class="display-4">Christmas Queue 2019</h1>
    @guest
        @include('components.warning-badge', [
            'icon' => 'warning',
            'warning' => 'You have to be logged in to request modding!'
        ])
        <br>

        @include('components.login-button')
    @else
        Welcome, {{Auth::user()->username}} <br>
        <a href="{{ route('logout') }}">logout</a> <br>

        @if(Auth::user()->isAmbassador())
            You're an ambassador!
        @endif
    @endguest

    <hr width="30%">

    <h2>Beatmaps</h2>

    <!-- React -->
    <div id="user-listing" data='{!! json_encode(App\User::sorted()) !!}'></div>

    @auth
        <div id="beatmap-form"></div>
    @endauth

    <div id="beatmap-listing" data='{!! json_encode($beatmaps) !!}'></div>
@endsection
