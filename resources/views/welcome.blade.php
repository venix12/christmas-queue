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
        Once again this year, the Beatmap Nominator group is bringing back the best modding queue around for its 11th year, a tradition that continues to spread the joy and wonders of the winter. Like before, in order to make this a great success again, the Christmas Queue is in need of motivated individuals to help push things forward.
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
