<?php

// Generated from the Lottevo OpenAPI document. Do not edit.

namespace Lottevo\Resources;

use Lottevo\Resource;

final class Compliance extends Resource
{
    /**
     * The legal frame of every researched jurisdiction, optionally within one
     * country
     *
     * GET /compliance
     *
     * Countries and their states or provinces come in one list, each
     * country followed by its states. A US state carries the federal tax
     * level alongside its own, so it can be read on its own.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function list(array $query = []): array
    {
        return $this->client->request('GET', '/compliance', query: $query);
    }
}
