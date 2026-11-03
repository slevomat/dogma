<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Math\Interval;

use Dogma\Arr;
use Dogma\Time\Interval\DateInterval;
use Dogma\Time\Interval\DateTimeInterval;
use Dogma\Time\Interval\NightInterval;
use Dogma\Time\Interval\TimeInterval;
use function array_values;
use function count;

trait IntervalSetNormalizeMixin
{

    /**
     * @deprecated Unnecessary anymore, intervals always normalized.
     */
    public function normalize(): self
    {
        return $this;
    }

    /**
     * Join overlapping intervals.
     *
     * @param T[] $intervals
     * @return list<T>
     *
     * @template T of FloatInterval|IntInterval|DateInterval|DateTimeInterval|NightInterval|TimeInterval
     */
    private static function normalizeIntervals(array $intervals): array
    {
        $intervals = array_values($intervals);
        foreach ($intervals as $i => $interval) {
            if ($interval->isEmpty()) {
                unset($intervals[$i]);
            }
        }

        $intervals = array_values($intervals);
        $intervals = Arr::sortComparableValues($intervals);
        $count = count($intervals) - 1;
        for ($n = 0; $n < $count; $n++) {
            if ($intervals[$n]->intersects($intervals[$n + 1]) || $intervals[$n]->touches($intervals[$n + 1])) {
                /** @var T $envelope */
                $envelope = $intervals[$n]->envelope($intervals[$n + 1]);
                $intervals[$n + 1] = $envelope;
                unset($intervals[$n]);
            }
        }

        return array_values($intervals);
    }

}
