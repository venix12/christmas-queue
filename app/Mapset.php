<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mapset extends Model
{
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
