<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{$title}} | Christmas Queue</title>

        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css2?family=Exo+2&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href='{{ mix('/css/app.css') }}'>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>

    <body class="d-flex flex-column">
        @include('components._navbar', [
            'routes' => ['home', 'beatmaps', 'users'],
            'title' => 'Christmas Queue 2021',
        ])

        <main class="py-4">
            <div class="container">
                <div class="app text-center">
                    @yield('content')

                    @auth
                        @if (Auth::user()->isAmbassador())
                            <div class="section section--1 section--small d-inline-flex">
                                <div class="navigation-bar__el navigation-bar__el--home">
                                    <a href="{{ route('admin.log') }}">log</a>
                                </div>

                                <div class="navigation-bar__el navigation-bar__el--home">
                                    <a href="{{ route('admin.beatmaps') }}">manage beatmaps</a>
                                </div>

                                <div class="navigation-bar__el navigation-bar__el--home">
                                    <a href="{{ route('admin.users') }}">manage users</a>
                                </div>

                                <div class="navigation-bar__el navigation-bar__el--home">
                                    <a href="{{ route('admin.forum-export-beatmaps') }}">forum beatmaps</a>
                                </div>

                                <div class="navigation-bar__el navigation-bar__el--home">
                                    <a href="{{ route('admin.forum-export-modders') }}">forum modders</a>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </main>

        @include('components.footer')

        <script class="current-user">
            var currentUser = {!! Auth::check() ? json_encode(Auth::user()) : '{}' !!}

            $('.current-user').remove();
        </script>


        <script>
            $(function () {
                $('[title]').tooltip({ animation: false })
            })
        </script>

        <script>
            var osuBaseUrl = '{{ config('app.osu_base_url') }}';
        </script>

        <script src='{{ asset('/js/app.js') }}'></script>
    </body>
</html>
