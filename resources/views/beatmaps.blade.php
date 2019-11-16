@extends('main', [
    'title' => 'Beatmaps'
])

@section('content')
    <h1 class="display-4">Beatmap Listing</h1>

    <!-- React -->
    @guest
        @include('components.warning-badge', [
            'icon' => 'warning',
            'warning' => 'You have to be logged in to request modding!'
        ])
    @else
        @include('components.warning-badge', [
            'icon' => 'warning',
            'warning' => 'Please, request <b>finished</b> beatmaps <b>only</b>!'
        ])

        <div id="beatmap-form"></div>
    @endguest

    <div id="beatmap-listing" data='{{ json_encode($beatmaps) }}' filters="true"></div>
@endsection