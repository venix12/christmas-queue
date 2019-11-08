@extends('main')

@section('content')
    <div id="navbar" current='Beatmaps'></div>
    <h1 class="display-4">Beatmap Listing</h1>

    <!-- React -->
    @auth
    <div id="beatmap-form"></div>
    @endauth

    <div id="beatmap-listing" data='{{ json_encode($beatmaps) }}' filters="true"></div>
@endsection