<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma;

use BadMethodCallException;
use function array_key_exists;

/**
 * @template TKey of array-key
 * @template TValue
 */
trait ImmutableArrayAccessMixin
{

    /** @param TKey $key */
    public function offsetExists(mixed $key): bool
    {
        return array_key_exists($key, $this->toArray());
    }

    /**
     * @param TKey $key
     * @return TValue|null
     */
    public function offsetGet(mixed $key): mixed
    {
        return $this->items[$key];
    }

    /**
     * @param TKey $key
     * @param TValue $value
     * @throws BadMethodCallException
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
        throw new BadMethodCallException('Cannot modify an item of immutable list.');
    }

    /**
     * @param TKey $key
     * @throws BadMethodCallException
     */
    public function offsetUnset(mixed $key): void
    {
        throw new BadMethodCallException('Cannot unset an item of immutable list.');
    }

}
