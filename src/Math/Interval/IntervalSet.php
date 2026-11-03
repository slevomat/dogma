<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Math\Interval;

use ArrayAccess;
use BadMethodCallException;
use Countable;
use Dogma\Dumpable;
use Dogma\Equalable;
use IteratorAggregate;

/**
 * @template T of Interval|ModuloInterval
 * @implements IteratorAggregate<int, T>
 * @implements ArrayAccess<int, T>
 */
abstract class IntervalSet implements Equalable, Dumpable, IteratorAggregate, Countable, ArrayAccess
{

    /**
     * @return list<T>
     */
    abstract public function getIntervals(): array;

    abstract public function isEmpty(): bool;

    //abstract public function containsValue(T $value): bool;

    /** @return T */
    abstract public function envelope(): Interval|ModuloInterval;

    //abstract public function normalize(): IntervalSet<T>;

    //abstract public function add(IntervalSet<T> $set): IntervalSet<T>;

    //abstract public function addIntervals(Interval<T> ...$intervals): IntervalSet<T>;

    //abstract public function subtract(IntervalSet<T> $set): IntervalSet<T>;

    //abstract public function subtractIntervals(Interval<T> ...$intervals): IntervalSet<T>;

    //abstract public function intersect(IntervalSet<T> $set): IntervalSet<T>;

    //abstract public function intersect(Interval<T> ...$intervals): IntervalSet<T>;

    //abstract public function filterByLength(string $operator, int|float $length): IntervalSet<T>;

    /**
     * @param callable(T): (T|array<array-key, T>|IntervalSet<T>) $mapper
     * @return array<array-key, T>
     */
    abstract public function map(callable $mapper): array;

    /**
     * Map and filter
     * @param callable(T): (T|array<array-key, T>|IntervalSet<T>|null) $mapper
     * @return self<T>
     */
    abstract public function collect(callable $mapper): self;

    /**
     * @throws BadMethodCallException
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new BadMethodCallException('Class is immutable');
    }

    /**
     * @throws BadMethodCallException
     */
    public function offsetUnset(mixed $offset): void
    {
        throw new BadMethodCallException('Class is immutable');
    }

}
