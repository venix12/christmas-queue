@extends('main', [
    'title' => 'Log'
])

@section('content')
    @include('components._header', [
        'color' => 'admin',
        'icon' => 'wrench',
        'section' => 'Log',
    ])

    @include('components.session')

    <div class="user-listing">
        @foreach($events as $event)
            <div class="user-listing__bg">
                <div class="user-listing__card">
                    <div>
                        <div>
                            <img class="user-listing__avatar" src="https://a.ppy.sh/{{$event->user->osu_id}}">
                            <a href="{{ config('app.osu_base_url') }}/u/{{$event->user->osu_id}}" class="user-listing__el user-listing__el--link">{{$event->user->username}}</a>
                            <span class="user-listing__el user-listing__el--content">
                                {{$event->action}}
                            </span>
                        </div>
                    </div>
                    <div class="user-listing__el user-listing__el--content">
                        {{substr($event->created_at, 0, 16)}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $events->links('components.paginator') }}
@endsection
