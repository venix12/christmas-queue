@extends('main', [
    'title' => 'Manage Users'
])

@php
    $admins = [654108, 1541323, 5999631];

    $add = 'Add to the';
    $rm = 'Remove from the';
@endphp

@section('content')
    <h1 class="display-4">Manage Users</h1>
    <hr width="30%">

    @include('components.session')

    @foreach ($users as $user)
        <div class="user-listing__bg">
            <div class="user-listing__card">
                <div>
                    <img class="user-listing__avatar" src="https://a.ppy.sh/{{$user->osu_id}}">
                    <a href="https://osu.ppy.sh/u/{{$user->osu_id}}" class="user-listing__el">{{$user->username}}</a>

                    {!! $user->isAmbassador ? usergroup_badge('ambassador') : '' !!}
                    {!! $user->isModder ? usergroup_badge('modder') : '' !!}
                    {!! $user->isNominator ? usergroup_badge('nominator') : '' !!}
                </div>
                <div>
                    <form action={{ route('add_usergroup') }} method="POST">
                        @csrf

                        <input type="hidden" name="group" value="0">
                        <input type="hidden" name="username" value='{{$user->username}}'>
                        <button type="submit" class="button button--circle button--circle--small bg--lightgray" title="{{$user->isModder ? $rm : $add}} modders">
                            <i class="fa fa-{{$user->isModder ? 'minus' : 'plus'}}"></i>
                        </button>
                    </form>

                    <form action={{ route('add_usergroup') }} method="POST">
                        @csrf

                        <input type="hidden" name="group" value="1">
                        <input type="hidden" name="username" value='{{$user->username}}'>
                        <button type="submit" class="button button--circle button--circle--small bg--purple" title="{{$user->isNominator ? $rm : $add}} nominators">
                            <i class="fa fa-{{$user->isNominator ? 'minus' : 'plus'}}"></i>
                        </button>
                    </form>

                    @if(in_array(Auth::user()->osu_id, $admins))
                        <form action={{ route('add_usergroup') }} method="POST">
                            @csrf

                            <input type="hidden" name="group" value="2">
                            <input type="hidden" name="username" value='{{$user->username}}'>
                            <button type="submit" class="button button--circle button--circle--small bg--green" title="{{$user->isAmbassador ? $rm : $add}} ambassadors">
                                <i class="fa fa-{{$user->isAmbassador ? 'minus' : 'plus'}}"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endsection