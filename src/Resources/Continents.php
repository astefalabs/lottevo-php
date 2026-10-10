<?php

// Generated from the Lottevo OpenAPI document. Do not edit.

namespace Lottevo\Resources;

use Lottevo\Resource;

final class Continents extends Resource
{
    /**
     * The continents that have any lottery. Unpaginated on purpose: there are only
     * a handful of them, and a client building a dropdown should not have to
     * follow a cursor for it
     *
     * GET /continents
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function list(array $query = []): array
    {
        return $this->client->request('GET', '/continents', query: $query);
    }
}
