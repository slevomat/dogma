<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma;

use IteratorIterator;
use Traversable;
use function call_user_func;

/**
 * Calls given callback on each value or key and returns result.
 *
 * @template TKey of array-key
 * @template TValue
 * @extends IteratorIterator<mixed, mixed, Traversable<TKey, TValue>>
 */
class CallbackIterator extends IteratorIterator
{
    use StrictBehaviorMixin;

    /** @var callable(TValue): mixed */
    private mixed $valuesCallback;

    /** @var (callable(TKey|null): mixed)|null */
    private mixed $keysCallback;

    /**
     * @param iterable<TKey, TValue> $iterable
     * @param callable(TValue): mixed $valuesCallback
     * @param (callable(TKey|null): mixed)|null $keysCallback
     */
    public function __construct(iterable $iterable, callable $valuesCallback, ?callable $keysCallback = null)
    {
        $this->valuesCallback = $valuesCallback;
        $this->keysCallback = $keysCallback;

        $iterable = IteratorHelper::iterableToIterator($iterable);

        parent::__construct($iterable);
    }

    public function key(): mixed
    {
        $key = parent::key();

        if ($this->keysCallback === null) {
            return $key;
        }

        /** @var TKey|null $key */
        return call_user_func($this->keysCallback, $key);
    }

    public function current(): mixed
    {
        $value = parent::current();

        return call_user_func($this->valuesCallback, $value);
    }

}
