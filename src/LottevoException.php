<?php

namespace Lottevo;

use RuntimeException;

/**
 * A refused or failed call. Branch on `$apiCode` (`lottery_not_entitled`,
 * `quota_exceeded`, …) — the message is translated and will change.
 * `$status` is 0 when the API was never reached.
 */
final class LottevoException extends RuntimeException
{
    /**
     * @param  array<string, mixed>  $body
     */
    public function __construct(
        string $message,
        public readonly int $status,
        public readonly ?string $apiCode = null,
        public readonly ?string $requestId = null,
        public readonly ?int $retryAfter = null,
        public readonly array $body = [],
    ) {
        parent::__construct($message, $status);
    }

    /**
     * @param  array<string, mixed>  $body
     * @param  array<string, string>  $headers
     */
    public static function fromResponse(int $status, array $body, array $headers): self
    {
        return new self(
            (string) ($body['message'] ?? "The Lottevo API answered {$status}."),
            $status,
            isset($body['code']) ? (string) $body['code'] : null,
            $headers['x-request-id'] ?? null,
            isset($body['retry_after']) ? (int) $body['retry_after'] : (isset($headers['retry-after']) ? (int) $headers['retry-after'] : null),
            $body,
        );
    }
}
