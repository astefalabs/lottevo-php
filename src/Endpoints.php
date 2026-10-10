<?php

// Generated from the Lottevo OpenAPI document. Do not edit.

namespace Lottevo;

abstract class Endpoints
{
    public readonly Resources\Account $account;

    public readonly Resources\Lotteries $lotteries;

    public readonly Resources\Compliance $compliance;

    public readonly Resources\Draws $draws;

    public readonly Resources\Continents $continents;

    public readonly Resources\Countries $countries;

    public readonly Resources\States $states;

    public readonly Resources\Webhooks $webhooks;

    protected function bootResources(): void
    {
        $this->account = new Resources\Account($this);
        $this->lotteries = new Resources\Lotteries($this);
        $this->compliance = new Resources\Compliance($this);
        $this->draws = new Resources\Draws($this);
        $this->continents = new Resources\Continents($this);
        $this->countries = new Resources\Countries($this);
        $this->states = new Resources\States($this);
        $this->webhooks = new Resources\Webhooks($this);
    }
}
