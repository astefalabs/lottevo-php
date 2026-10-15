<?php

// Generated from the Lottevo OpenAPI document. Do not edit.

namespace Lottevo\Resources;

use Lottevo\Resource;

final class Account extends Resource
{
    /**
     * What the calling key is: its account's plan, its scopes and how many
     * requests the account has made today. The integration smoke test — a client
     * can verify a key works without needing a scope, and read its own ceiling
     * from the answer
     *
     * GET /account
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function get(array $query = []): array
    {
        return $this->client->request('GET', '/account', query: $query);
    }
}
