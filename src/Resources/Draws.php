<?php

// Generated from the Lottevo OpenAPI document. Do not edit.

namespace Lottevo\Resources;

use Lottevo\Resource;

final class Draws extends Resource
{
    /**
     * The results feed, newest first, across the whole catalogue or narrowed to a
     * game, a country or a date range. The cursor is what a client re-syncs
     * against; an offset page would be shifted by every draw that lands while it
     * reads. Results older than the history your plan includes are not listed —
     * `/v1/account` gives the exact start
     *
     * GET /draws
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function list(array $query = []): array
    {
        return $this->client->request('GET', '/draws', query: $query);
    }

    /**
     * The latest result of every game, paginated over games — the board a
     * dashboard renders. A game with no result yet is listed with `latest_draw:
     * null`
     *
     * GET /draws/latest
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function latest(array $query = []): array
    {
        return $this->client->request('GET', '/draws/latest', query: $query);
    }

    /**
     * One result by id. Ids are stable, and this is the URL a webhook payload
     * points back at. A result older than the history your plan includes is
     * refused with `history_not_included`
     *
     * GET /draws/{draw}
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function get(string|int $draw, array $query = []): array
    {
        return $this->client->request('GET', '/draws/'.rawurlencode((string) $draw), query: $query);
    }

    /**
     * Everything that happened to the results, in order
     *
     * GET /draws/changes
     *
     * The feed to keep a copy of the results in step without re-reading
     * them. Each entry says what happened — `published`, `updated` (money
     * filled in later: the jackpot, the prize categories), `revised` (the
     * numbers or the draw time corrected) or `deleted` — which fields it
     * touched, and carries the draw as it stands now; a deleted draw carries
     * only its id. Start from `filter[since]`, then follow `next_cursor`
     * from one request to the next. Entries older than the retention window
     * are no longer listed, except corrections; a client further behind
     * than that re-reads the results feed.
     * Query `per_page`
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function changes(array $query = []): array
    {
        return $this->client->request('GET', '/draws/changes', query: $query);
    }

    /**
     * The corrections of one result, oldest first
     *
     * GET /draws/{draw}/revisions
     *
     * Each entry holds the fields that were corrected, with their values
     * before and after. A result that was never corrected has none.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function revisions(string|int $draw, array $query = []): array
    {
        return $this->client->request('GET', '/draws/'.rawurlencode((string) $draw).'/revisions', query: $query);
    }
}
