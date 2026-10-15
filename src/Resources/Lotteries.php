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
     * One game, addressed by its code — plus its last results and its payout
     * table, which are cheap for one game and are what a game's own page shows
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
     * Generate tickets for a game
     *
     * GET /lotteries/{lottery}/generate
     *
     * Every ticket is valid for the game and distinct from the others, and
     * every ticket the filters allow is equally likely unless `weighting`
     * says otherwise. No filter changes the chance of winning: they choose
     * which tickets you play, not how likely they are to come up.
     *
     * `meta.space` counts the tickets the filters allow — exactly while only
     * the counted filters are used (`odd`, `low`, `ranges`, `include`,
     * `exclude`, `numbers_from`), estimated once the sum, neighbour, ending,
     * group-of-ten or popular-pattern filters are added (`exact: false`).
     * A request no ticket can meet is refused at once with the reason
     * (`generator_impossible`), and one asking for more tickets than exist
     * says how many do (`generator_space_too_small`).
     *
     * `seed` makes a request repeatable: the same request with the same seed
     * returns the same tickets while the game's history stands. The seed
     * used is always in `meta.seed`.
     *
     * The filters read from past draws (`numbers_from`, `weighting`) need at
     * least 100 draws in `window` (`not_enough_draws`). `avoid_popular`
     * leaves out the patterns many players mark — the latest draw, only
     * dates, even-step rows, long runs, one ending, one multiple: in a
     * pari-mutuel game a prize is then shared with fewer winners.
     *
     * Digit games (Pick 3, Joker, …) take only `exclude`, `sum_min`,
     * `sum_max`, `never_drawn`, `avoid_popular`, `numbers_from` and
     * `weighting`; games whose count of numbers is the result, games drawn
     * from several drums and races answer 422 `generator_unsupported`.
     * Query `count`: How many tickets to generate, 1 to 50.
     * Query `size`: How many numbers each ticket holds, within the game's own range (`meta.sizes`). Defaults to the most a ticket may hold.
     * Query `seed`: A whole number from 0 to 9007199254740991 that makes the request repeatable. Chosen at random when absent.
     * Query `odd`: How many odd numbers each ticket holds, exactly.
     * Query `low`: How many numbers from the lower half of the pool (`meta.low`) each ticket holds, exactly.
     * Query `ranges`: Exact counts from stretches of the pool, as `from-to:count` separated by commas: `1-10:2,11-20:1` is two numbers from 1 to 10 and one from 11 to 20. The stretches may not overlap.
     * Query `include`: Numbers every ticket holds, separated by commas.
     * Query `exclude`: Numbers no ticket holds, separated by commas.
     * Query `sum_min`: The lowest sum of a ticket's numbers.
     * Query `sum_max`: The highest sum of a ticket's numbers.
     * Query `max_consecutive`: The longest run of neighbouring numbers a ticket may hold (14, 15, 16 is a run of 3).
     * Query `max_same_ending`: The most numbers a ticket may hold with the same last digit.
     * Query `max_per_decade`: The most numbers a ticket may hold from one group of ten (1-10, 11-20, …).
     * Query `never_drawn`: Only tickets no past draw held. For number games, only when a ticket holds as many numbers as a draw.
     * Query `avoid_popular`: Leave out the patterns many players mark.
     * Query `numbers_from`: Draw the tickets only from the `hot` (most drawn), `cold` (least drawn) or `overdue` (longest absent) numbers of `window`. Historical analysis, not a prediction.
     * Query `numbers_from_top`: How many of those numbers to draw from. Defaults to a third of the pool.
     * Query `weighting`: `hot` picks numbers drawn more often in `window` more often, `cold` the reverse, `none` weighs every ticket alike. A preference, not a better chance.
     * Query `window`: The past draws `numbers_from` and `weighting` read: `meta.available_windows` on the game's statistics lists them.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function generate(string|int $lottery, array $query = []): array
    {
        return $this->client->request('GET', '/lotteries/'.rawurlencode((string) $lottery).'/generate', query: $query);
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
     * Query `window`: How far back to count: `day`, `two_days` … `six_days`, `seven_days`, `fourteen_days`, `thirty_days`, `three_months`, `six_months`, `nine_months`, `year` or `all_time`. The windows shorter than seven days exist only for games drawn several times a day; any other value counts the whole history. `meta.available_windows` lists the game's.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function statistics(string|int $lottery, array $query = []): array
    {
        return $this->client->request('GET', '/lotteries/'.rawurlencode((string) $lottery).'/statistics', query: $query);
    }

    /**
     * How a game's past draws are spread, each figure beside what a fair draw
     * would have produced
     *
     * GET /lotteries/{lottery}/statistics/distributions
     *
     * Historical analysis of past results, not a prediction of future ones.
     * Counted over the main numbers of the draws made with the game's current
     * number pool, within the window; `meta` says which draws that was.
     *
     * - `sum`: the sum of each draw's numbers, in ranges.
     * - `odd_even` and `high_low`: how many odd, and how many low numbers, a draw held. Low is the lower half of the pool (`high_low.low`).
     * - `consecutive`: pairs of neighbouring numbers in a draw, such as 14 and 15. The fair-draw figure is only given for games where a number cannot come up twice.
     * - `positions`: which numbers came up at each position — the lowest number first, or the order of the draw for games where it is part of the result (`positions.order`). Null for games drawing more than 10 numbers or from more than 100.
     * - `gaps`: how many draws passed between two appearances of the same number.
     * - `randomness`: a chi-square test of how evenly the numbers came up. A small `p_value` (below 0.01) says the spread is unlikely from a fair draw; it is null while too few draws are counted. For a digit game where some position draws from a narrower range (a first digit from 1 to 6 only), every figure follows each position's own range and the test runs position by position; `expected_per_number` is then the smallest count any position expects of a digit.
     *
     * Bingo-style games, whose count of numbers is the result, and games
     * drawn from several drums answer 422 `distributions_unsupported`.
     * Query `window`: How far back to count: `day`, `two_days` … `six_days`, `seven_days`, `fourteen_days`, `thirty_days`, `three_months`, `six_months`, `nine_months`, `year` or `all_time`. The windows shorter than seven days exist only for games drawn several times a day; any other value counts the whole history. `meta.available_windows` lists the game's.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function statisticsDistributions(string|int $lottery, array $query = []): array
    {
        return $this->client->request('GET', '/lotteries/'.rawurlencode((string) $lottery).'/statistics/distributions', query: $query);
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
     * For a fixed-odds game (Pick 3, keno, fixed-odds lotto bets) name the bet with
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

    /**
     * Build a reduced system (a wheel) on your numbers
     *
     * GET /lotteries/{lottery}/wheel
     *
     * Choose more numbers than a ticket holds and a guarantee: with
     * `guarantee=4&if_drawn=5`, whenever 5 of the draw's numbers are among
     * yours, at least one ticket holds 4 of them. `if_drawn` defaults to
     * `guarantee`. The system plays far fewer tickets than every combination
     * of your numbers (`meta.full_system`); it is not always the smallest
     * system there is, but the guarantee always holds.
     *
     * The guarantee is about the main numbers only. `bonus` puts the same
     * bonus numbers on every ticket; without it the tickets carry none, and
     * `meta.bonus` says what each still needs. `meta.odds.condition_met_one_in`
     * is how rarely enough of the draw's numbers fall among yours for the
     * guarantee to apply: a system changes which tickets you play, not the
     * chance of winning.
     *
     * The same request always returns the same tickets. A system too large
     * to work out answers 422 `wheel_too_large`; digit games, games drawn
     * from several drums and races answer 422 `wheel_unsupported`. This route
     * has a per-minute rate of its own, on top of the plan's.
     * Query `numbers`: Your numbers, separated by commas: more than a ticket holds, and at most 40.
     * Query `size`: How many numbers each ticket holds, within the game's own range (`meta.sizes`). Defaults to the most a ticket may hold.
     * Query `guarantee`: How many of the drawn numbers one ticket is sure to hold, from 1 to the ticket's size.
     * Query `if_drawn`: How many of the draw's numbers must be among yours for the guarantee to apply: from `guarantee` to the draw's count. Defaults to `guarantee`.
     * Query `bonus`: The bonus numbers every ticket carries, separated by commas, for a game whose bonus is played separately.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function wheel(string|int $lottery, array $query = []): array
    {
        return $this->client->request('GET', '/lotteries/'.rawurlencode((string) $lottery).'/wheel', query: $query);
    }
}
