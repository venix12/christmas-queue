@extends('main', [
    'title' => 'Log'
])

@section('content')
    <h1 class="display-4">Log</h1>
    <hr width="30%">

    @include('components.session')

    <table class="table table-borderless table-dark table-sm">
        <thead>
            <tr>
                <th scope="col">User</th>
                <th scope="col">Action</th>
                <th scope="col">Date</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($events as $event)
                <tr style="font-size: 0.8rem">
                    <td>{{$event->user->username}}</td>
                    <td>{{$event->action}}</td>
                    <td>{{$event->created_at}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection