# Lottevo PHP

A thin client for the [Lottevo](https://lottevo.com) lottery data API: results, jackpots, schedules,
prize breakdowns and statistics for lotteries worldwide. No dependencies beyond `ext-curl`.

```bash
composer require lottevo/lottevo-php
```

## First call

```php
$lottevo = new Lottevo\Client('lv_…'); // or set LOTTEVO_API_KEY and pass nothing

$account = $lottevo->account->get();                              // the smoke test: plan, scopes, quota
$draws = $lottevo->lotteries->draws('EU-002', ['per_page' => 5]); // EuroJackpot's latest results

foreach ($draws['data'] as $draw) {
    echo $draw['drawn_at'], ' ', implode(' ', $draw['numbers']), PHP_EOL;
}
```

Every operation of the API is a method on a resource — `$lottevo->lotteries`, `->draws`,
`->webhooks`, `->countries` … — and returns the decoded JSON as an array. Path parameters come first,
then the query (or, for `create`/`update`, the JSON body):

```php
$lottevo->draws->list(['filter' => ['lottery' => ['EU-002', 'RO-001'], 'from' => '2026-01-01'], 'include' => 'prizes']);
$lottevo->lotteries->check('EU-002', ['numbers' => '4,7,12,31,44', 'bonus' => '8,11']);
```

## Pagination

Listings are cursor-paginated. `paginate()` walks every page from the one you give it:

```php
foreach ($lottevo->paginate($lottevo->lotteries->list()) as $lottery) {
    echo $lottery['code'], PHP_EOL;
}
```

## Errors

A refused call throws `Lottevo\LottevoException`. Branch on `apiCode`, not on the message:

```php
try {
    $lottevo->lotteries->draws('US-001');
} catch (Lottevo\LottevoException $e) {
    if ($e->apiCode === 'lottery_not_entitled') { /* not in your plan */ }
    $e->status; $e->requestId; $e->retryAfter;
}
```

`$lottevo->lastHeaders()` holds the last answer's headers, including `x-quota-remaining`.

## Options

```php
new Lottevo\Client(apiKey: 'lv_…', locale: 'ro', timeout: 30);
```

`locale` is sent as `Accept-Language`: game names, schedules and error messages come back in it.

Full reference: <https://lottevo.com/docs/reference>.
