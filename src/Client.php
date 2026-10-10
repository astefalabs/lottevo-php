<?php

namespace Lottevo;

use Generator;
use InvalidArgumentException;

/**
 * The Lottevo API client. Every operation hangs off a resource property —
 * `$client->lotteries->draws('EU-002')` — and returns the decoded JSON.
 * A failure throws LottevoException carrying the API's stable `code`.
 */
final class Client extends Endpoints
{
    public const VERSION = '0.1.0';

    public const DEFAULT_BASE_URL = 'https://api.lottevo.com/v1';

    private readonly string $apiKey;

    private readonly string $baseUrl;

    /** @var array<string, string> */
    private array $lastHeaders = [];

    /**
     * @param  string|null  $apiKey  Defaults to the LOTTEVO_API_KEY environment variable.
     * @param  string|null  $locale  Sent as Accept-Language: names, schedules and errors come back in it.
     */
    public function __construct(
        ?string $apiKey = null,
        string $baseUrl = self::DEFAULT_BASE_URL,
        private readonly ?string $locale = null,
        private readonly int $timeout = 30,
    ) {
        $apiKey ??= getenv('LOTTEVO_API_KEY') ?: null;

        if ($apiKey === null || $apiKey === '') {
            throw new InvalidArgumentException('Pass an API key or set the LOTTEVO_API_KEY environment variable.');
        }

        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->bootResources();
    }

    /**
     * Send one call and decode its JSON. A list value in the query is sent
     * comma-separated, the way the API reads `filter[lottery]=EU-002,RO-001`.
     *
     * @param  array<string, mixed>  $query
     * @param  array<string, mixed>  $body
     * @return array<string, mixed>
     */
    public function request(string $method, string $path, array $query = [], array $body = []): array
    {
        $url = $this->baseUrl.$path.($query === [] ? '' : '?'.http_build_query($this->flattenLists($query)));
        $headers = array_filter([
            'Authorization: Bearer '.$this->apiKey,
            'Accept: application/json',
            'User-Agent: lottevo-php/'.self::VERSION,
            $this->locale === null ? null : 'Accept-Language: '.$this->locale,
            $body === [] ? null : 'Content-Type: application/json',
        ]);

        $this->lastHeaders = [];
        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HEADERFUNCTION => function ($curl, string $line): int {
                if (str_contains($line, ':')) {
                    [$name, $value] = explode(':', $line, 2);
                    $this->lastHeaders[strtolower(trim($name))] = trim($value);
                }

                return strlen($line);
            },
        ]);

        if ($body !== []) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body, JSON_THROW_ON_ERROR));
        }

        $raw = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        $error = curl_error($curl);

        if ($raw === false) {
            throw new LottevoException("Could not reach the Lottevo API: {$error}", 0, 'network_error');
        }

        $payload = $raw === '' ? [] : json_decode($raw, true);

        if ($status >= 400 || ! is_array($payload)) {
            throw LottevoException::fromResponse($status, is_array($payload) ? $payload : [], $this->lastHeaders);
        }

        return $payload;
    }

    /**
     * Every item of a listing, following `links.next` from the page given
     * until there is none: `foreach ($client->paginate($client->draws->list()) as $draw)`.
     *
     * @param  array<string, mixed>  $page
     * @return Generator<int, array<string, mixed>>
     */
    public function paginate(array $page): Generator
    {
        while (true) {
            yield from $page['data'] ?? [];

            $next = $page['links']['next'] ?? null;

            if ($next === null) {
                return;
            }

            // The key is only ever sent to the host the client was built for.
            if (! str_starts_with($next, $this->baseUrl.'/')) {
                throw new LottevoException("Refusing to follow a next page outside {$this->baseUrl}: {$next}", 0, 'unexpected_next_page');
            }

            $page = $this->request('GET', substr($next, strlen($this->baseUrl)));
        }
    }

    /**
     * The headers of the last answer, lower-cased — `x-quota-remaining`,
     * `x-ratelimit-remaining`, `x-request-id`.
     *
     * @return array<string, string>
     */
    public function lastHeaders(): array
    {
        return $this->lastHeaders;
    }

    /**
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    private function flattenLists(array $query): array
    {
        return array_map(
            fn (mixed $value): mixed => is_array($value) ? (array_is_list($value) ? implode(',', $value) : $this->flattenLists($value)) : (is_bool($value) ? ($value ? 'true' : 'false') : $value),
            $query,
        );
    }
}
