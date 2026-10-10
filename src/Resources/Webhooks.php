<?php

// Generated from the Lottevo OpenAPI document. Do not edit.

namespace Lottevo\Resources;

use Lottevo\Resource;

final class Webhooks extends Resource
{
    /**
     * What this subscription has been sent, newest first. Filterable by
     * `filter[status]=dead` — which is the dead-letter list, and the only thing
     * most clients ever look at
     *
     * GET /webhooks/{webhookEndpoint}/deliveries
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function deliveries(string|int $webhookEndpoint, array $query = []): array
    {
        return $this->client->request('GET', '/webhooks/'.rawurlencode((string) $webhookEndpoint).'/deliveries', query: $query);
    }

    /**
     * Offer a delivery again — the recovery path for a receiver that was down
     * longer than the backoff lasts
     *
     * POST /webhooks/{webhookEndpoint}/deliveries/{uuid}/replay
     *
     * The uuid is kept, so a receiver that DID process the original still
     * recognises it as the same event and can drop it. Only a delivery that
     * is no longer being retried — dead, or already delivered — can be
     * offered again.
     *
     * @param  array<string, mixed>  $body
     * @return array<string, mixed>
     */
    public function replay(string|int $webhookEndpoint, string|int $uuid, array $body = []): array
    {
        return $this->client->request('POST', '/webhooks/'.rawurlencode((string) $webhookEndpoint).'/deliveries/'.rawurlencode((string) $uuid).'/replay', body: $body);
    }

    /**
     * The subscriptions this key holds
     *
     * GET /webhooks
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function list(array $query = []): array
    {
        return $this->client->request('GET', '/webhooks', query: $query);
    }

    /**
     * Subscribe. The signing secret comes back on this response only —
     * afterwards it is encrypted at rest and can be rotated but not read
     *
     * POST /webhooks
     *
     * @param  array<string, mixed>  $body
     * @return array<string, mixed>
     */
    public function create(array $body = []): array
    {
        return $this->client->request('POST', '/webhooks', body: $body);
    }

    /**
     * Show one subscription
     *
     * GET /webhooks/{webhookEndpoint}
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function get(string|int $webhookEndpoint, array $query = []): array
    {
        return $this->client->request('GET', '/webhooks/'.rawurlencode((string) $webhookEndpoint), query: $query);
    }

    /**
     * Change what a subscription listens to, or switch it back on after it was
     * disabled for being unreachable
     *
     * PATCH /webhooks/{webhookEndpoint}
     *
     * @param  array<string, mixed>  $body
     * @return array<string, mixed>
     */
    public function update(string|int $webhookEndpoint, array $body = []): array
    {
        return $this->client->request('PATCH', '/webhooks/'.rawurlencode((string) $webhookEndpoint), body: $body);
    }

    /**
     * Unsubscribe for good, taking the delivery history with it
     *
     * DELETE /webhooks/{webhookEndpoint}
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function delete(string|int $webhookEndpoint, array $query = []): array
    {
        return $this->client->request('DELETE', '/webhooks/'.rawurlencode((string) $webhookEndpoint), query: $query);
    }

    /**
     * Replace the signing secret, returning the new one once. The old one stops
     * verifying immediately — rotate when it has leaked, not on a schedule
     *
     * POST /webhooks/{webhookEndpoint}/rotate-secret
     *
     * @param  array<string, mixed>  $body
     * @return array<string, mixed>
     */
    public function rotateSecret(string|int $webhookEndpoint, array $body = []): array
    {
        return $this->client->request('POST', '/webhooks/'.rawurlencode((string) $webhookEndpoint).'/rotate-secret', body: $body);
    }
}
