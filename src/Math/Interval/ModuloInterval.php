<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Math\Interval;

use Dogma\Comparable;
use Dogma\Dumpable;
use Dogma\Equalable;

interface ModuloInterval /*<T>*/ extends Equalable, Comparable, Dumpable
{

    // queries ---------------------------------------------------------------------------------------------------------

    public function format(): string;

    public function getStart(): mixed; //: T

    public function getEnd(): mixed; //: T

    public function isEmpty(): bool;

    //public function equals(self $interval): bool;

    //public function containsValue(T $value): bool;

    //public function contains(self $interval): bool;

    //public function intersects(self $interval): bool;

    //public function touches(self $interval): bool;

    // actions ---------------------------------------------------------------------------------------------------------

    /** @return static[] */
    public function split(int $parts): array;

    /**
     * @param mixed[]|array<T> $intervalStarts
     * @return static[]
     */
    public function splitBy(array $intervalStarts): array;

    // A1****A2****B1****B2 -> [A1, B2]
    //public function envelope(self ...$items): self;

    // A and B
    // A1----B1****A2----B2 -> [B1, A2]
    // A1----A2    B1----B2 -> [empty]
    //public function intersect(self ...$items): ModuloIntervalSet<T>;

    // A or B
    // A1****B1****A2****B2 -> {[A1, B2]}
    // A1****A2    B1****B2 -> {[A1, A2], [B1, B2]}
    //public function union(self ...$items): ModuloIntervalSet<T>;

    // A xor B
    // A1****B1----A2****B2 -> {[A1, A2], [B1, B2]}
    // A1****A2    B1****B2 -> {[A1, A2], [B1, B2]}
    //public function difference(self ...$items): ModuloIntervalSet<T>;

    // A minus B
    // A1****B1----A2----B2 -> {[A1, B1]}
    // A1****A2    B1----B2 -> {[A1, A2]}
    //public function subtract(self ...$items): ModuloIntervalSet<T>;

    /** @return IntervalSet<*>|ModuloIntervalSet<*> */
    public function invert(): IntervalSet|ModuloIntervalSet;

    // static ----------------------------------------------------------------------------------------------------------

    /**
     * @param ModuloInterval ...$items
     * @return ModuloInterval[][]|int[][] ($ident => ($interval, $count))
     */
    //public static function countOverlaps(self ...$items): array;

    /**
     * O(n log n)
     * @param ModuloInterval ...$items
     * @return ModuloInterval[]
     */
    //public static function explodeOverlaps(self ...$items): array;

    /**
     * @param self[] $intervals
     * @return self[]
     * @deprecated will be removed. use Arr::sortComparable() instead.
     */
    public static function sort(array $intervals): array;

    /**
     * @param self[] $intervals
     * @return self[]
     * @deprecated will be removed. use Arr::sortComparable() instead.
     */
    public static function sortByStart(array $intervals): array;

}
