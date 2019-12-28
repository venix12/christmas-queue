<?php

namespace App;

use App\Exceptions\OsuApiException;
use Cache;
use Carbon\Carbon;
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
        $nextCallAt = Cache::get(self::RATE_KEY);

        if ($nextCallAt !== null) {
            while ($nextCallAt->isFuture()) {
                usleep(1000000 * self::RATE_LIMIT + 1);
            }
        }

        Cache::forever(self::RATE_KEY, Carbon::now()->addMilliseconds(1000 * self::RATE_LIMIT));

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
