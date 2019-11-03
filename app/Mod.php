<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mod extends Model
{
    protected $fillable = [
        'mapset_id',
        'type',
        'user_id'
    ];

    public function mapset()
    {
        return $this->hasOne('App\Mapset');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
