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

/**
 * Combines values from two given iterators as keys and values. Iterators should return same number of items.
 *
 * @template TKey of array-key
 * @template TValue
 * @implements Iterator<TKey, TValue>
 */
class CombineIterator implements Iterator
{
    use StrictBehaviorMixin;

    /** @var Iterator<array-key, TKey> */
    private Iterator $keys;

    /** @var Iterator<array-key, TValue> */
    private Iterator $values;

    /**
     * @param iterable<array-key, TKey> $keys
     * @param iterable<array-key, TValue> $values
     */
    public function __construct(iterable $keys, iterable $values)
    {
        $this->keys = IteratorHelper::iterableToIterator($keys);
        $this->values = IteratorHelper::iterableToIterator($values);
    }

    public function rewind(): void
    {
        $this->keys->rewind();
        $this->values->rewind();
    }

    public function next(): void
    {
        $this->keys->next();
        $this->values->next();
    }

    public function valid(): bool
    {
        $keysValid = $this->keys->valid();
        $valuesValid = $this->values->valid();
        if ($keysValid xor $valuesValid) {
            throw new UnevenIteratorSourcesException(
                $keysValid ? 'Values iterator runned out of values.' : 'Keys iterator runned out of values.'
            );
        }

        return $keysValid && $valuesValid;
    }

    /** @return TValue|null */
    public function current(): mixed
    {
        return $this->values->valid() ? $this->values->current() : null;
    }

    /**
     * @return TKey|null
     */
    public function key(): mixed
    {
        return $this->keys->valid() ? $this->keys->current() : null;
    }

}
