@extends('main')

@section('content')
    <div id="navbar" current='Manage'></div>
    <h1 class="display-4">Manage Beatmaps</h1>
    <hr width="30%">
    Beatmaps waiting for approval ({{ count($beatmapsNotApproved) }})

    <!-- React -->
    <div id="beatmap-listing" data='{{ json_encode($beatmapsNotApproved) }}'></div>

    <hr width="30%">
    Deleted beatmaps ({{count($beatmapsDeleted)}})

    <!-- React -->
    <div id="beatmap-listing2" data='{{ json_encode($beatmapsDeleted) }}'></div>
@endsection