@extends('main', [
    'title' => 'Home'
])

@section('content')
    <div id="navbar" current='Home'></div>
    <h1 class="display-4">Christmas Queue 2019</h1>

    <div class="text-field" style="margin-bottom: 10px">
        Once again this year,  the Christmas Queue continues for its ninth year of operation, a tradition that continues to spread the joy and wonders of the winter. Like before, in order to make this a great success again, the Christmas Queue is in need of motivated individuals to help push things forward. This year, we will make at least one beatmap pack and maybe even a news post about the newly ranked beatmaps that will be released just before Christmas.
        <br><br>
        Join us on <a href="https://discord.gg/782TTSN" style="text-decoration: none !important">Discord</a>!
        <br><br>
        If you aren't listed as a modder on this website and want to be one, contact an ambassador to get added!
    </div><br>

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
    @endguest

    <hr width="30%">
    <h1>Beatmaps</h1>

    <!-- React -->
    <div id="beatmap-listing" data='{{ json_encode($beatmaps) }}'></div>
    <a class="nav__el nav__el--current bg--blue" href={{ route('beatmaps') }}>
        <i class="fa fa-chevron-down"></i> Show more <i class="fa fa-chevron-down"></i>
    </a>
@endsection