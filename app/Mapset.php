<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mapset extends Model
{
    protected $fillable = [
        'beatmapset_artist',
        'beatmapset_creator',
        'beatmapset_osu_id',
        'beatmapset_title',
        'user_id',
        'osu_user_id'
    ];
}
