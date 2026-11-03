<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma;

use Iterator;
use function current;
use function key;
use function next;
use function reset;

/**
 * Minimal interface replacement of bloated native ArrayIterator
 *
 * @template TKey of array-key = array-key
 * @template TValue = mixed
 * @implements Iterator<TKey, TValue>
 */
class ArrayIterator implements Iterator
{
    use StrictBehaviorMixin;

    /**
     * @param array<TKey, TValue> $array
     */
    public function __construct(protected array $array)
    {
    }

    public function rewind(): void
    {
        reset($this->array);
    }

    public function next(): void
    {
        next($this->array);
    }

    public function valid(): bool
    {
        return key($this->array) !== null;
    }

    /**
     * @return TKey|null
     */
    public function key(): mixed
    {
        return key($this->array);
    }

    /** @return TValue */
    public function current(): mixed
    {
        /** @var TValue $current */
        $current = current($this->array);

        return $current;
    }

}
