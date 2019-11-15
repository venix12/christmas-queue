<?php

namespace App;

use Guzzle;

class OsuApi
{
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    private function call(string $resource, array $query)
    {
        $query['k'] = $this->apiKey;
        $response = Guzzle::get('https://osu.ppy.sh/api/' . $resource, ['query' => $query]);

        return json_decode($response->getBody());
    }

    public function getBeatmapset(int $id)
    {
        return $this->call('get_beatmaps', ['s' => $id]);
    }
}
