<?php

// Generated from the Lottevo OpenAPI document. Do not edit.

namespace Lottevo\Resources;

use Lottevo\Resource;

final class Lotteries extends Resource
{
    /**
     * The legal frame of every jurisdiction a lottery is sold in
     *
     * GET /lotteries/{lottery}/compliance
     *
     * A national game lists its country only: which states or provinces
     * sell it is not known for every game, and the country entry says when
     * the rules differ between them.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function compliance(string|int $lottery, array $query = []): array
    {
        return $this->client->request('GET', '/lotteries/'.rawurlencode((string) $lottery).'/compliance', query: $query);
    }

    /**
     * The catalogue. Inactive games are not listed
     *
     * GET /lotteries
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function list(array $query = []): array
    {
        return $this->client->request('GET', '/lotteries', query: $query);
    }

    /**
     * One game, addressed by its code, with the long description the list leaves
     * out — plus its last results and its payout table, which are cheap for one
     * game and are what a game's own page shows
     *
     * GET /lotteries/{lottery}
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function get(string|int $lottery, array $query = []): array
    {
        return $this->client->request('GET', '/lotteries/'.rawurlencode((string) $lottery), query: $query);
    }

    /**
     * How complete and how fast a game's results have been
     *
     * GET /lotteries/{lottery}/data-quality
     *
     * Over the last 30 days: how many draws the game's schedule called for,
     * how many were published, how many the operator did not hold, and how
     * many are missing — plus how long after each draw's scheduled time its
     * result was available, as the median, the 90th percentile and the
     * slowest. Recomputed once a day. `completeness` is null for a game drawn
     * on a calendar no fixed schedule describes; `data` is null for a game
     * that has not been measured yet.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function dataQuality(string|int $lottery, array $query = []): array
    {
        return $this->client->request('GET', '/lotteries/'.rawurlencode((string) $lottery).'/data-quality', query: $query);
    }

    /**
     * One game's result history, newest first, as far back as your plan includes
     * (see `/v1/account`). Pages stay equally fast however deep you walk back
     *
     * GET /lotteries/{lottery}/draws
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function draws(string|int $lottery, array $query = []): array
    {
        return $this->client->request('GET', '/lotteries/'.rawurlencode((string) $lottery).'/draws', query: $query);
    }

    /**
     * How current a game's results are right now
     *
     * GET /lotteries/{lottery}/freshness
     *
     * Whether the latest scheduled draw has its result (`current`), is still
     * within the time results normally take (`awaiting`) or is late and
     * flagged as missing (`overdue`); when the game's results last changed
     * here, which is not the same as when it was last drawn; how long after
     * its scheduled time the latest result arrived, against the usual delay;
     * and how many results were corrected after publication recently.
     * Computed on every request, unlike the daily data-quality figures.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function freshness(string|int $lottery, array $query = []): array
    {
        return $this->client->request('GET', '/lotteries/'.rawurlencode((string) $lottery).'/freshness', query: $query);
    }

    /**
     * How a game's announced jackpot has moved
     *
     * GET /lotteries/{lottery}/jackpots
     *
     * Every distinct figure the operator announced for an upcoming draw, newest
     * first, with the span over which it stood unchanged. A figure revised
     * during the week becomes a new entry, so the list shows how the estimate
     * grew toward each draw. The history starts when we began recording it.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function jackpots(string|int $lottery, array $query = []): array
    {
        return $this->client->request('GET', '/lotteries/'.rawurlencode((string) $lottery).'/jackpots', query: $query);
    }

    /**
     * The payout table of a fixed-odds game
     *
     * GET /lotteries/{lottery}/payouts
     *
     * Some games do not split a pool between winners: the prize is a function
     * of the ticket — what was bet on, how many numbers were played, how many
     * matched — so it is the same for every draw and is published here rather
     * than with each result. A game that splits a pool returns an empty list;
     * its money is on the draws.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function payouts(string|int $lottery, array $query = []): array
    {
        return $this->client->request('GET', '/lotteries/'.rawurlencode((string) $lottery).'/payouts', query: $query);
    }

    /**
     * When a game draws: each schedule written out in the language of the request,
     * plus the next few occurrences already resolved to UTC instants so a client
     * does not have to handle DST to build a calendar
     *
     * GET /lotteries/{lottery}/schedule
     *
     * `regular` is false for a game that draws on irregular days, such as
     * one tied to horse-racing fixtures: it has no timetable, so the
     * schedules, the next draw and the upcoming occurrences are empty.
     * Query `occurrences`
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function schedule(string|int $lottery, array $query = []): array
    {
        return $this->client->request('GET', '/lotteries/'.rawurlencode((string) $lottery).'/schedule', query: $query);
    }

    /**
     * The three rankings for a game: most drawn, least drawn, and longest without
     * appearing
     *
     * GET /lotteries/{lottery}/statistics
     *
     * Historical analysis of past results, not a prediction of future ones.
     * Query `combo_size`
     * Query `limit`
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function statistics(string|int $lottery, array $query = []): array
    {
        return $this->client->request('GET', '/lotteries/'.rawurlencode((string) $lottery).'/statistics', query: $query);
    }

    /**
     * Check a ticket against a game's history
     *
     * GET /lotteries/{lottery}/check
     *
     * Pass the ticket as `numbers=3,11,17,24,38,45` — plus `bonus=7` for a game
     * whose bonus is played separately — and get every past draw it matched,
     * newest first. For a number game a draw is listed when it contained at
     * least `min_matched` of the numbers; for a digit game (Pick 3, Joker, …)
     * when it was an exact or any-order hit, or matched at least `min_matched`
     * digits by position or in a row from either end. `meta.summary` counts
     * every outcome over the whole window, and for a game whose operator
     * publishes prizes per draw `meta.winnings` adds up what the ticket would
     * have won, by currency, at the amounts paid per winner then — gross, as
     * published; `complete` is false when some draws could not be judged.
     * For a fixed-odds game (Lotto's wheels, Pick 3, keno) name the bet with
     * `bet_type` — one of the game's `ticket_check.bet_types` — and
     * optionally `stake`, and every draw is priced at the game's payout table
     * instead: `meta.bet` says the stake, currency and whether the amounts
     * are before withholdings. The window is `range` (`3months`,
     * `6months`, `1year`, `2years`, `all`) or `from`/`to`, and never reaches
     * back before the game took its current format nor further than your plan
     * includes (`meta.window`).
     * Query `numbers`
     * Query `bonus`
     * Query `bet_type`
     * Query `stake`
     * Query `min_matched`
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function check(string|int $lottery, array $query = []): array
    {
        return $this->client->request('GET', '/lotteries/'.rawurlencode((string) $lottery).'/check', query: $query);
    }

    /**
     * Check up to twenty tickets against a game's history at once
     *
     * POST /lotteries/{lottery}/check
     *
     * Send `tickets` — each `{"numbers": [...], "bonus": [...]}`, plus
     * `bet_type` and `stake` for a fixed-odds game — with the same window as
     * a single check (`range` or `from`/`to`), and get each ticket's summary:
     * how many draws it matched, and how. The draws themselves are
     * listed by the single-ticket check. Counts as one request. A game with a
     * very long history may need a shorter window for many tickets at once
     * (`ticket_check_too_large`).
     *
     * @param  array<string, mixed>  $body
     * @return array<string, mixed>
     */
    public function checkBatch(string|int $lottery, array $body = []): array
    {
        return $this->client->request('POST', '/lotteries/'.rawurlencode((string) $lottery).'/check', body: $body);
    }
}
