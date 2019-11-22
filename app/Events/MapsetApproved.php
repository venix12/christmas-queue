<?php

namespace App\Events;

use App\Mapset;

class MapsetApproved
{
    public $mapset;

    /**
     * Create a new event instance.
     *
     * @param  Mapset  $mapset
     * @return void
     */
    public function __construct(Mapset $mapset)
    {
        $this->mapset = $mapset;
    }
}
