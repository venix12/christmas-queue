@extends('main', [
    'title' => 'Home'
])

@section('content')
    @include('components._header', [
        'color' => 'home',
        'icon' => 'home',
        'section' => 'Home',
    ])

    <div class="section section--3">
        Once again this year,  the Christmas Queue continues for its tenth year of operation, a tradition that continues to spread the joy and wonders of the winter. Like before, in order to make this a great success again, the Christmas Queue is in need of motivated individuals to help push things forward. This year, we will make at least one beatmap pack about the newly ranked beatmaps that will be released just before Christmas.
        <br><br>
        Join us on <a href="https://discord.gg/782TTSN" style="text-decoration: none !important">Discord</a>!
        <br><br>
        If you aren't listed as a modder on this website and want to be one, contact an ambassador to get added!
    </div>

    @guest
        <div class="section section--4">
            @include('components.login-button')
        </div>
    @endguest

    <div class="section section--1">
        <h3>Recently approved beatmaps</h3>

        <!-- React -->
        <div id="react--beatmap-listing" ></div>

        <a class="show-more" href={{ route('beatmaps') }}>
            <span class="show-more--icon">
                <i class="fa fa-angle-down"></i>
            </span>

            <span class="show-more__label"></span>

            <span class="show-more--icon">
                <i class="fa fa-angle-down"></i>
            </span>
        </a>
    </div>

    <script id="beatmap-data">
        {!! json_encode($beatmaps) !!}
    </script>
@endsection
