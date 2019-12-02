@extends('main', [
    'title' => 'Manage Beatmaps'
])

@section('content')
    <h1 class="display-4">Manage Beatmaps</h1>
    <hr width="30%">
    Beatmaps waiting for approval ({{ count($beatmapsNotApproved) }})

    <!-- React -->
    <div id="react--beatmap-listing"></div>

    <hr width="30%">
    Deleted beatmaps ({{count($beatmapsDeleted)}})

    <!-- React -->
    <div id="react--beatmap-listing--d"></div>

    <script id="beatmap-data">
        {!! json_encode($beatmapsNotApproved) !!}
    </script>

    <script id="beatmap-data--d">
        {!! json_encode($beatmapsDeleted) !!}
    </script>
@endsection