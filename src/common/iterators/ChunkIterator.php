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

/**
 * Returns results from given iterator in chunks.
 *
 * @template TKey of array-key
 * @template TValue
 * @extends IteratorIterator<int, list<TValue>, Traversable<TKey, TValue>>
 */
class ChunkIterator extends IteratorIterator
{
    use StrictBehaviorMixin;

    private int $chunkSize;

    private int $key = 0;

    /** @var list<TValue> */
    private array $chunk = [];

    /**
     * @param iterable<TKey, TValue> $iterable
     */
    public function __construct(iterable $iterable, int $chunkSize)
    {
        Check::positive($chunkSize);
        $iterable = IteratorHelper::iterableToIterator($iterable);

        $this->chunkSize = $chunkSize;

        parent::__construct($iterable);
    }

    public function rewind(): void
    {
        parent::rewind();

        $this->next();
        $this->key = 0;
    }

    public function next(): void
    {
        $this->chunk = [];
        for ($i = 0; $i < $this->chunkSize && parent::valid(); $i++) {
            /** @var TValue $value */
            $value = parent::current();
            $this->chunk[] = $value;
            parent::next();
        }
        $this->key++;
    }

    /**
     * @return list<TValue>
     */
    public function current(): array
    {
        return $this->chunk;
    }

    public function key(): int
    {
        return $this->key;
    }

    public function valid(): bool
    {
        return (bool) $this->chunk;
    }

}
