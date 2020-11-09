@extends('main', [
    'title' => 'Beatmaps'
])

@section('content')
    @include('components._header', [
        'color' => 'beatmaps',
        'icon' => 'tree',
        'section' => 'Beatmaps',
    ])

    <div class="section section--2 section--small">
        request finished beatmaps only!
    </div>

    <div class="section section--3">
        <h3>Request form</h3>

        @auth
            <!-- React -->
            <div id="react--beatmap-form"></div>
        @else
            <div class="url-clean url-clean--red">
                <a href="{{ route('login') }}">please, log in to request modding!</a>
            </div>
        @endauth
    </div>

    <div class="section section--1">
        <!-- React -->
        <div id="react--beatmap-listing" filters="true"></div>
    </div>

    <script id="beatmap-data">
        {!! json_encode($beatmaps) !!}
    </script>
@endsection
