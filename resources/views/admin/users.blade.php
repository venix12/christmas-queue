@extends('main', [
    'title' => 'Manage Users'
])

@php
    $add = 'Add to the';
    $rm = 'Remove from the';
@endphp

@section('content')
    @include('components._header', [
        'color' => 'admin',
        'icon' => 'wrench',
        'section' => 'Manage users',
    ])

    @include('components.session')

    <div class="user-listing">
        @foreach ($users as $user)
            <div class="user-listing__bg">
                <div class="user-listing__card">
                    <div>
                        <img class="user-listing__avatar" src="https://a.ppy.sh/{{$user->osu_id}}">
                        <a href="https://osu.ppy.sh/u/{{$user->osu_id}}" class="user-listing__el user-listing__el--link">{{$user->username}}</a>

                        {!! $user->isAmbassador ? usergroup_badge('ambassador') : '' !!}
                        {!! $user->isModder ? usergroup_badge('modder') : '' !!}
                        {!! $user->isNominator ? usergroup_badge('nominator') : '' !!}
                    </div>
                    <div>
                        <div style="font-size: .8em">
                            @foreach ($user->gamemodes() as $gamemode)
                                {{ gamemode($gamemode) }}
                            @endforeach
                        </div>


                        <form action="{{ route('admin.users.switch-gamemode') }}" method="POST" style="margin-right: 30px">
                            @csrf

                            <input type="hidden" name="username" value='{{$user->username}}'>

                            <select name="gamemode">
                                @foreach (App\Mapset::MODES as $mode)
                                    <option value="{{ $mode }}">{{ gamemode($mode) }}</option>
                                @endforeach
                            </select>

                            <button type="submit" class="button button--circle button--circle--small bg--lightgray" title="switch selected gamemode">
                                <i class="fa fa-random" style="margin-left: -1px"></i>
                            </button>
                        </form>

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

                        @if (auth()->user()->isAdmin())
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
    </div>
@endsection
