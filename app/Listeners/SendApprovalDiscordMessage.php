<?php

namespace App\Listeners;

use App\Events\MapsetApproved;
use Cache;
use Guzzle;

class SendApprovalDiscordMessage
{
    const COLORS = [
        12264744,
        1338170,
    ];

    /**
     * Handle the event.
     *
     * @param  MapsetApproved  $event
     * @return void
     */
    public function handle(MapsetApproved $event)
    {
        if (env('DISCORD_WEBHOOK_URL') === null) {
            return;
        }

        $color = Cache::get('discord-color', 0);
        $mapset = $event->mapset;

        Guzzle::post(env('DISCORD_WEBHOOK_URL'), [
            'json' => [
                'embeds' => [[
                    'title' => 'Beatmapset approved',
                    'description' => "**[$mapset->beatmapset_artist - $mapset->beatmapset_title](https://osu.ppy.sh/beatmapsets/$mapset->beatmapset_osu_id)** by [$mapset->beatmapset_creator]($mapset->osu_user_id)",
                    'color' => self::COLORS[$color],
                    'thumbnail' => [
                        'url' => 'https://b.ppy.sh/thumb/' . $mapset->beatmapset_osu_id . 'l.jpg',
                    ],
                ]],
            ],
        ]);

        Cache::forever('discord-color', $color === count(self::COLORS) - 1 ? 0 : $color + 1);
    }
}
