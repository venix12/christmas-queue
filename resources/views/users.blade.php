@extends('main')

@section('content')
    <div id="navbar" current='Users'></div>
    <h1 class="display-4">Participants</h1>

    <!-- React -->
    <div id="user-listing" data='{!! json_encode(App\User::sorted()) !!}'></div>
@endsection