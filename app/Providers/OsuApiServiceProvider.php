<?php

namespace App\Providers;

use App\OsuApi;
use Illuminate\Support\ServiceProvider;

class OsuApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('osu-api', function () {
            return new OsuApi(config('app.osu_legacy_api.key'));
        });
    }
}
