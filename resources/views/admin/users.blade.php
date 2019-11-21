@extends('main', [
    'title' => 'Manage Users'
])

@php
    $check = '<i class="fa fa-check color--green"></i>';
    $mark = '<i class="fa fa-remove color--orange"></i>';
@endphp

@section('content')
    <h1 class="display-4">Manage Users</h1>
    <hr width="30%">

    @include('components.session')

    <table class="table table-borderless table-dark table-sm">
        <thead>
            <tr>
                <th scope="col">User</th>
                <th scope="col">Ambassador</th>
                <th scope="col">Nominator</th>
                <th scope="col">Modder</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
                <tr style="font-size: 0.8rem">
                    <td>
                        <a href='https://osu.ppy.sh/u/{{$user->osu_id}}'>
                            {{$user->username}}
                        </a>

                        <form action={{ route('add_usergroup') }} method="POST" style="display: inline-block">
                            @csrf

                            <input type="hidden" name="group" value="0">
                            <input type="hidden" name="username" value='{{$user->username}}'>
                            <a href="#" onclick='this.parentNode.submit();'>(modder)</a>
                        </form>
                    </td>
                    <td>{!! $user->isAmbassador ? $check : $mark !!}</td>
                    <td>{!! $user->isNominator ? $check : $mark !!}</td>
                    <td>{!! $user->isModder ? $check : $mark !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><hr width="30%"><br>

    <form action={{ route('add_usergroup') }} method="POST">
        @csrf

        <div class="form-wrapper">
            <input autocomplete="off" class="input-invisible" name="username" style="text-align: center; width: 150px" type="text">
        </div>
        <div class="color--gray">username</div>

        <div class="form-wrapper">
            <input autocomplete="off" class="input-invisible" name="group" style="text-align: center; width: 50px" type="text">
        </div>
        <p class="color--gray">group ID</p>

        <input class="button bg--green" type="submit" value="Add to usergroup!">
    </form>
@endsection