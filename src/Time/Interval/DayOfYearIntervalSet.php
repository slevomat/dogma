<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Time\Interval;

use Dogma\Arr;
use Dogma\ArrayIterator;
use Dogma\Check;
use Dogma\Equalable;
use Dogma\Math\Interval\IntervalSet;
use Dogma\Math\Interval\IntervalSetDumpMixin;
use Dogma\ShouldNotHappenException;
use Dogma\StrictBehaviorMixin;
use Dogma\Time\DayOfYear;
use ReturnTypeWillChange;
use Traversable;
use function array_merge;
use function array_shift;
use function array_values;
use function count;
use function implode;
use function is_array;
use function reset;
use function sprintf;

/**
 * @implements IntervalSet<DayOfYearInterval>
 */
class DayOfYearIntervalSet extends IntervalSet
{
    use StrictBehaviorMixin;
    use IntervalSetDumpMixin;

    /** @var DayOfYearInterval[] */
    private $intervals;

    /**
     * @param DayOfYearInterval[] $intervals
     */
    final public function __construct(array $intervals)
    {
        /** @var DayOfYearInterval[] $intervals */
        $intervals = Arr::values(Arr::filter($intervals, static function (DayOfYearInterval $interval): bool {
            return !$interval->isEmpty();
        }));

        $this->intervals = $intervals;
    }

    public function format(string $format = DayOfYearInterval::DEFAULT_FORMAT, ?DateTimeIntervalFormatter $formatter = null): string
    {
        return implode(', ', Arr::map($this->intervals, static function (DayOfYearInterval $interval) use ($format, $formatter): string {
            return $interval->format($format, $formatter);
        }));
    }

    /**
     * @return DayOfYearInterval[]
     */
    public function getIntervals(): array
    {
        return $this->intervals;
    }

	public function count(): int
	{
		return count($this->intervals);
	}

	/**
	 * @param int $offset
	 */
	#[ReturnTypeWillChange]
	public function offsetGet($offset): DayOfYearInterval
	{
		if (isset($this->intervals[$offset])) {
			return $this->intervals[$offset];
		}

		throw new ShouldNotHappenException(sprintf('Offset %d does not exist.', $offset));
	}

	/**
	 * @param int $offset
	 */
	public function offsetExists($offset): bool
	{
		return isset($this->intervals[$offset]);
	}

    /**
     * @return Traversable<DayOfYearInterval>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->intervals);
    }

    public function isEmpty(): bool
    {
        return $this->intervals === [];
    }

    /**
     * @param self $other
     * @return bool
     */
    public function equals(Equalable $other): bool
    {
        Check::instance($other, self::class);

        $otherIntervals = $other->getIntervals();
        if (count($this->intervals) !== count($otherIntervals)) {
            return false;
        }
        foreach ($this->intervals as $i => $interval) {
            if (!$interval->equals($otherIntervals[$i])) {
                return false;
            }
        }

        return true;
    }

    public function containsValue(DayOfYear $value): bool
    {
        foreach ($this->intervals as $interval) {
            if ($interval->containsValue($value)) {
                return true;
            }
        }

        return false;
    }

    public function containsInterval(DayOfYearInterval $interval): bool
    {
        foreach ($this->intervals as $int) {
            if ($int->contains($interval)) {
                return true;
            }
        }

        return false;
    }

    public function envelope(): DayOfYearInterval
    {
        if ($this->intervals === []) {
            return DayOfYearInterval::empty();
        } else {
            return reset($this->intervals)->envelope(...$this->intervals);
        }
    }

    /**
     * Join overlapping intervals in set.
     * @return self
     */
    public function normalize(): self
    {
        return new static(self::normalizeIntervals($this->intervals));
    }

    /** @phpstan-pure */
    public function add(self $set): self
    {
        return $this->addIntervals(...$set->intervals);
    }

    /** @phpstan-pure */
    public function addIntervals(DayOfYearInterval ...$intervals): self
    {
        return new static(array_merge($this->intervals, $intervals));
    }

    /**
     * Remove another set of intervals from this one.
     *
     * @phpstan-pure
     * @return self
     */
    public function subtract(self $set): self
    {
        return $this->subtractIntervals(...$set->intervals);
    }

    /** @phpstan-pure */
    public function subtractIntervals(DayOfYearInterval ...$intervals): self
    {
        $sources = $this->intervals;
        $results = [];
        while ($result = array_shift($sources)) {
            foreach ($intervals as $interval) {
                $result = $result->subtract($interval);
                if (count($result->intervals) === 0) {
                    continue 2;
                } elseif (count($result->intervals) === 2) {
                    $sources[] = $result->intervals[1];
                }
                $result = $result->intervals[0];
            }
            if (!$result->isEmpty()) {
                $results[] = $result;
            }
        }

        /** @var DayOfYearInterval[] $results */
        $results = $results;

        return new static($results);
    }

    /**
     * Intersect with another set of intervals.
     *
     * @phpstan-pure
     * @return self
     */
    public function intersect(self $set): self
    {
        return $this->intersectIntervals(...$set->intervals);
    }

    /** @phpstan-pure */
    public function intersectIntervals(DayOfYearInterval ...$intervals): self
    {
        $results = [];
        foreach ($this->intervals as $result) {
            foreach ($intervals as $interval) {
                if ($result->intersects($interval)) {
                    $results = array_merge($results, $result->intersect($interval)->getIntervals());
                }
            }
        }

        return new static($results);
    }

    /**
     * @phpstan-pure
     * @return DayOfYearInterval[]
     */
    public function map(callable $mapper): array
    {
        $results = [];
        foreach ($this->intervals as $interval) {
            $result = $mapper($interval);
            if ($result instanceof DayOfYearInterval) {
                $results[] = $result;
            } elseif (is_array($result)) {
                $results = array_merge($results, $result);
            } elseif ($result instanceof self) {
                $results = array_merge($results, $result->getIntervals());
            } else {
                throw new ShouldNotHappenException('Expected DayOfYearInterval or DayOfYearIntervalSet or array of DayOfYearIntervals.');
            }
        }

        return $results;
    }

    /** @phpstan-pure */
    public function collect(callable $mapper): self
    {
        $results = [];
        foreach ($this->intervals as $interval) {
            $result = $mapper($interval);
            if ($result instanceof DayOfYearInterval) {
                $results[] = $result;
            } elseif (is_array($result)) {
                $results = array_merge($results, $result);
            } elseif ($result instanceof self) {
                $results = array_merge($results, $result->getIntervals());
            } elseif ($result === null) {
                continue;
            } else {
                throw new ShouldNotHappenException('Expected DayOfYearInterval or DayOfYearIntervalSet or array of DayOfYearIntervals.');
            }
        }

        return new static($results);
    }

	/**
	 * Join overlapping intervals.
	 *
	 * @param DayOfYearInterval[] $intervals
	 * @return DayOfYearInterval[]
	 */
	private static function normalizeIntervals(array $intervals): array
	{
		$intervals = array_values($intervals);
		foreach ($intervals as $i => $interval) {
			if ($interval->isEmpty()) {
				unset($intervals[$i]);
			}
		}

		$intervals = Arr::sortComparableValues($intervals);
		$count = count($intervals) - 1;
		for ($n = 0; $n < $count; $n++) {
			$intervalA = $intervals[$n];
			$intervalB = $intervals[$n + 1];
			if (
				$intervalA->containsValue($intervalB->getStart())
				|| $intervalA->getEnd()->equals($intervalB->getStart()->subtractDay())
			) {
				$intervals[$n + 1] = new DayOfYearInterval($intervalA->getStart(), $intervalB->getEnd());
				unset($intervals[$n]);
			} elseif (
				$intervalB->containsValue($intervalA->getStart())
				|| $intervalB->getEnd()->equals($intervalA->getStart()->subtractDay())
			) {
				$intervals[$n + 1] = new DayOfYearInterval($intervalB->getStart(), $intervalA->getEnd());
				unset($intervals[$n]);
			}
		}

		return array_values($intervals);
	}

}
