<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OsuApi;

class Mapset extends Model
{
    const MODES = ['osu', 'taiko', 'catch', 'mania'];
    const RANKED_STATUSES = [
        -2 => 'graveyard',
        -1 => 'wip',
        0 => 'pending',
        1 => 'ranked',
        2 => 'approved',
        3 => 'qualified',
        4 => 'loved',
    ];

    protected $casts = [
        'catch' => 'boolean',
        'mania' => 'boolean',
        'osu' => 'boolean',
        'taiko' => 'boolean'
    ];

    protected $fillable = [
        'beatmapset_artist',
        'beatmapset_creator',
        'beatmapset_osu_id',
        'beatmapset_title',
        'catch',
        'mania',
        'osu',
        'osu_user_id',
        'taiko',
        'user_id'
    ];

    public static function createFromOnline(int $beatmapsetId, User $user)
    {
        $apiBeatmaps = OsuApi::getBeatmapset($beatmapsetId);
        $mapset = new static();

        if ($mapset->fillOnline($apiBeatmaps)) {
            $mapset->user_id = $user->id;
            $mapset->save();

            return $mapset;
        }
    }

    public function updateOnline()
    {
        $apiBeatmaps = OsuApi::getBeatmapset($this->beatmapset_osu_id);

        if ($this->fillOnline($apiBeatmaps)) {
            $this->save();
        }
    }

    private function fillOnline(array $apiBeatmaps) : bool
    {
        if (count($apiBeatmaps) === 0) {
            return false;
        }

        $modes = [false, false, false, false];

        foreach ($apiBeatmaps as $beatmap) {
            $modes[$beatmap->mode] = true;
        }

        $this->fill([
            'osu_user_id' => $apiBeatmaps[0]->creator_id,
            'beatmapset_artist' => $apiBeatmaps[0]->artist,
            'beatmapset_creator' => $apiBeatmaps[0]->creator,
            'beatmapset_osu_id' => $apiBeatmaps[0]->beatmapset_id,
            'beatmapset_title' => $apiBeatmaps[0]->title,
            'osu' => $modes[0],
            'taiko' => $modes[1],
            'catch' => $modes[2],
            'mania' => $modes[3],
        ]);

        return true;
    }
}
