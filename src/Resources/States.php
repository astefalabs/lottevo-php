<?php

// Generated from the Lottevo OpenAPI document. Do not edit.

namespace Lottevo\Resources;

use Lottevo\Resource;

final class States extends Resource
{
    /**
     * The states that have any lottery, optionally within one country
     *
     * GET /states
     * Query `filter[country]`
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function list(array $query = []): array
    {
        return $this->client->request('GET', '/states', query: $query);
    }
}
