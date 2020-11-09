@extends('main', [
    'title' => 'Manage Beatmaps'
])

@section('content')
    @include('components._header', [
        'color' => 'admin',
        'icon' => 'wrench',
        'section' => 'Manage beatmaps',
    ])

    <h3>Beatmaps waiting for approval ({{ $beatmapsNotApproved->count() }})</h3>

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
