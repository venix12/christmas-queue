@extends('main', [
    'title' => 'Participants'
])

@section('content')
    <h1 class="display-4">Participants</h1>

    <!-- React -->
    <div id="react--user-listing"></div>

    <script id="user-data">
        {!! json_encode(App\User::sorted()) !!}
    </script>
@endsection