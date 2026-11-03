<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Time;

use Countable;
use Dogma\InvalidValueException;
use function array_filter;
use function array_values;
use function count;
use function intval;

final readonly class DaysOfWeek implements Countable
{

    private const int ALL_DAYS = 127;

    public function __construct(public int $value = 0)
    {
        if ($value < 0 || ($value & ~self::ALL_DAYS) !== 0) {
            throw new InvalidValueException($value, self::class);
        }
    }

    public static function from(int $value): self
    {
        return new self($value);
    }

    public static function empty(): self
    {
        return new self();
    }

    /**
     * @param list<DayOfWeek> $days
     */
    public static function createFromDayOfWeekList(array $days): self
    {
        $value = 0;
        foreach ($days as $day) {
            $value |= 1 << ($day->value - 1);
        }

        return new self($value);
    }

    public static function createFromDays(DayOfWeek ...$days): self
    {
        return self::createFromDayOfWeekList(array_values($days));
    }

    public static function allDays(): self
    {
        return new self(self::ALL_DAYS);
    }

    public static function createWithAllDays(): self
    {
        return self::allDays();
    }

    public static function workDays(): self
    {
        return new self(self::ALL_DAYS >> 2);
    }

    public static function createWorkDays(): self
    {
        return self::workDays();
    }

    public static function weekend(): self
    {
        return new self(self::ALL_DAYS ^ self::workDays()->value);
    }

    public static function createWeekend(): self
    {
        return self::weekend();
    }

    public function contains(self|DayOfWeek $other): bool
    {
        $value = $other instanceof DayOfWeek
            ? 1 << ($other->value - 1)
            : $other->value;

        return ($this->value & $value) === $value;
    }

    public function containsDay(DayOfWeek $day): bool
    {
        return $this->contains($day);
    }

    public function containsAll(DayOfWeek ...$days): bool
    {
        return $this->contains(self::createFromDays(...$days));
    }

    public function containsAny(DayOfWeek ...$days): bool
    {
        return $this->intersects(self::createFromDays(...$days));
    }

    public function intersects(self $other): bool
    {
        return ($this->value & $other->value) !== 0;
    }

    public function intersect(self $other): self
    {
        return new self($this->value & $other->value);
    }

    public function union(self $other): self
    {
        return new self($this->value | $other->value);
    }

    public function subtract(self $other): self
    {
        return new self($this->value & ~$other->value);
    }

    public function diff(self $other): self
    {
        return $this->subtract($other);
    }

    public function difference(self $other): self
    {
        return new self($this->value ^ $other->value);
    }

    public function xor(self $other): self
    {
        return $this->difference($other);
    }

    public function invert(): self
    {
        return new self(self::ALL_DAYS ^ $this->value);
    }

    public function add(DayOfWeek ...$days): self
    {
        return $this->union(self::createFromDays(...$days));
    }

    public function remove(DayOfWeek ...$days): self
    {
        return $this->subtract(self::createFromDays(...$days));
    }

    /**
     * @return list<DayOfWeek>
     */
    public function toArray(): array
    {
        $days = [];
        foreach (DayOfWeek::cases() as $day) {
            if ($this->containsDay($day)) {
                $days[] = $day;
            }
        }

        return $days;
    }

    /**
     * @return list<DayOfWeek>
     */
    public function toDays(): array
    {
        return $this->toArray();
    }

    public function count(): int
    {
        return count($this->toArray());
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function matchesDay(DateOrDateTime $date): bool
    {
        return $this->containsDay(DayOfWeek::from(intval($date->format('N'))));
    }

    /**
     * @param DateOrDateTime[] $days
     * @return DateOrDateTime[]
     */
    public function filterDays(array $days): array
    {
        return array_filter($days, $this->matchesDay(...));
    }

}
