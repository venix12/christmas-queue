<?php

namespace App;

use App\Exceptions\OsuApiException;
use Cache;
use Guzzle;

class OsuApi
{
    const RATE_LIMIT = 0.1; // in seconds
    const RATE_KEY = 'osu-api-rate';

    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    private function call(string $resource, array $query)
    {
        while (Cache::has(RATE_KEY)) {
            usleep(1000000 * RATE_LIMIT + 1);
        }

        Cache::put(RATE_KEY, RATE_KEY, RATE_LIMIT / 60);

        $query['k'] = $this->apiKey;
        $response = Guzzle::get('https://osu.ppy.sh/api/' . $resource, ['query' => $query]);

        switch ($response->getStatusCode()) {
            case 200:
                return json_decode($response->getBody());
            case 401:
                throw new OsuApiException('Invalid API key');
            case 429:
                // probably unnecessary to handle this, but just in case
                return $this->call($resource, $query);
            default:
                throw new OsuApiException($response->getStatusCode());
        }
    }

    public function getBeatmapset(int $id)
    {
        return $this->call('get_beatmaps', ['s' => $id]);
    }
}
