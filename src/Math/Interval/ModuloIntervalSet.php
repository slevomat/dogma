<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Math\Interval;

use Dogma\Dumpable;
use Dogma\Equalable;
use IteratorAggregate;

/**
 * @template T of ModuloInterval
 * @extends IteratorAggregate<int, T>
 */
interface ModuloIntervalSet extends Equalable, Dumpable, IteratorAggregate
{

    /**
     * @return list<T>
     */
    public function getIntervals(): array;

    public function isEmpty(): bool;

    //public function containsValue(T $value): bool;

    /** @return T */
    public function envelope(): ModuloInterval;

    //public function normalize(): ModuloIntervalSet<T>;

    //public function add(IntervalSet<T> $set): ModuloIntervalSet<T>;

    //public function addIntervals(Interval<T> ...$intervals): ModuloIntervalSet<T>;

    //public function subtract(IntervalSet<T> $set): ModuloIntervalSet<T>;

    //public function subtractIntervals(Interval<T> ...$intervals): ModuloIntervalSet<T>;

    //public function intersect(IntervalSet<T> $set): ModuloIntervalSet<T>;

    //public function intersectIntervals(Interval<T> ...$intervals): ModuloIntervalSet<T>;

    //public function filterByLength(string $operator, int|float $length): ModuloIntervalSet<T>;

    /**
     * @param callable(T): (T|array<array-key, T>|self<T>) $mapper
     * @return array<array-key, T>
     */
    public function map(callable $mapper): array;

    /**
     * Map and filter
     * @param callable(T): (T|array<array-key, T>|self<T>|null) $mapper
     * @return self<T>
     */
    public function collect(callable $mapper): self;

}
