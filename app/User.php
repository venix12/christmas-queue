<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'catch',
        'isAmbassador',
        'isModder',
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

    public function isAmbassador() {
        return $this->isAmbassador;
    }

    public function isNominator() {
        return $this->isNominator;
    }

    public function isModder() {
        return $this->isModder;
    }

    public function mods() {
        return $this->hasMany(Mod::class);
    }

    public function requestedMaps()
    {
        return $this->hasMany(Mapset::class);
    }
}
