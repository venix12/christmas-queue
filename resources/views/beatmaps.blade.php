@extends('main')

@section('content')
    <div id="navbar" current='Beatmaps'></div>
    <h1 class="display-4">Beatmap Listing</h1>

    <!-- React -->
    <div id="beatmap-form"></div>
    <div id="beatmap-listing" data='{{ json_encode($beatmaps) }}'></div>
@endsection