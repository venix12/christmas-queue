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
        <div id="beatmap-form"></div>
    @endguest

    <div id="beatmap-listing" data='{{ json_encode($beatmaps) }}' filters="true"></div>
@endsection