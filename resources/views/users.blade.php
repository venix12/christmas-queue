@extends('main', [
    'title' => 'Participants'
])

@section('content')
    @include('components._header', [
        'color' => 'users',
        'icon' => 'user',
        'section' => 'Users',
    ])

    <div class="section section--2 section--small">
        List of current project participants. If you wish to get added as a modder, poke an ambassador!
    </div>

    <div class="section section--3">
        <!-- React -->
        <div id="react--user-listing"></div>
    </div>

    <script id="user-data">
        {!! json_encode(App\User::sorted()) !!}
    </script>
@endsection
