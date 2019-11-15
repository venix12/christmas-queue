<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
