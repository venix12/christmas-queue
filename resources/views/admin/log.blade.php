@extends('main', [
    'title' => 'Log'
])

@section('content')
    <h1 class="display-4">Log</h1>
    <hr width="30%">

    @include('components.session')

    <table class="table table-dark table-sm text-left">
        <thead>
            <tr>
                <th scope="col">User</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($events as $event)
                <tr style="font-size: 0.8rem">
                    <td>{{$event->user->username}}</td>
                    <td>{{$event->created_at}}</td>
                    <td>{{$event->action}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection