<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'catch',
        'isAmbassador',
        'isModder',
        'isNat',
        'isNominator',
        'mania',
        'osu',
        'osu_id',
        'taiko',
        'username',
    ];

    protected $casts = [
        'catch' => 'boolean',
        'isAmbassador' => 'boolean',
        'isNominator' => 'boolean',
        'isModder' => 'boolean',
        'mania' => 'boolean',
        'osu' => 'boolean',
        'taiko' => 'boolean',
    ];

    public static function sorted() {
        $users = self::orderBy('username')->get();

        $sorts = [
            'isAmbassador',
            'isModder'
        ];


        $users_api = [];

        foreach($sorts as $sort) {
            foreach($users->where($sort, true) as $user) {
                if(!in_array($user, $users_api)) {
                    $users_api[] = $user;
                }
            }
        }

        foreach($users as $user) {
            if(!in_array($user, $users_api)) {
                $users_api[] = $user;
            }
        }

        return $users_api;
    }

    public function gamemodes() {
        $gamemodes = [];

        foreach (Mapset::MODES as $mode) {
            if ($this->$mode === true) {
                $gamemodes[] = $mode;
            }
        }

        return $gamemodes;
    }

    public function isAdmin()
    {
        return in_array($this->osu_id, config('auth.admin_user_ids'), true);
    }

    public function mods() {
        return $this->hasMany(Mod::class);
    }

    public function requestedMaps()
    {
        return $this->hasMany(Mapset::class);
    }
}
