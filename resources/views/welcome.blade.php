@extends('main', [
    'title' => 'Home'
])

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

    <!-- React -->
    <div id="beatmap-listing" data='{{ json_encode($beatmaps) }}'></div>
    <a class="nav-badge" href={{ route('beatmaps') }}>
        <i class="fa fa-chevron-down"></i> Show more <i class="fa fa-chevron-down"></i>
    </a>
@endsection