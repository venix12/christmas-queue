<div class="navigation-bar">
    <div class="navigation-bar__main">
        <div class="navigation-bar__title">{{ $title }}</div>

        <div class="navigation-bar__routes">
            @foreach ($routes as $route)
                <div class="navigation-bar__el navigation-bar__el--{{ $route }}">
                    <a href="{{ route($route) }}">{{ $route }}</a>
                </div>
            @endforeach
        </div>
    </div>

    @auth
        <div class="navigation-profile">
            <img class="navigation-profile__avatar" src="https://a.ppy.sh/{{ Auth::user()->osu_id }}">

            <div>
                <div class="navigation-profile__username">logged in as
                    <span class="url-clean">
                        <a href="https://osu.ppy.sh/users/{{ Auth::user()->osu_id }}">
                            {{ Auth::user()->username }}
                        </a>
                    </span>
                </div>

                <div class="navigation-profile__logout">
                    <a href="{{ route('logout') }}">
                        logout
                    </a>
                </div>
            </div>
        </div>
    @endauth
</div>
