<?php

namespace Lottevo;

/**
 * The base of the generated resource classes in `Lottevo\Resources`.
 */
abstract class Resource
{
    public function __construct(protected readonly Client $client) {}
}
