<?php

// Generated from the Lottevo OpenAPI document. Do not edit.

namespace Lottevo\Resources;

use Lottevo\Resource;

final class Countries extends Resource
{
    /**
     * The countries that have any lottery, optionally within one continent. Lists
     * both the countries that own games and those where games are sold, so Cyprus
     * appears for the Greek games
     *
     * GET /countries
     * Query `filter[continent]`
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function list(array $query = []): array
    {
        return $this->client->request('GET', '/countries', query: $query);
    }
}
