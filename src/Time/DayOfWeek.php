<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

// spell-check-ignore: mon tue thu fri

namespace Dogma\Time;

use Dogma\InvalidValueException;
use function array_search;
use function is_int;
use function strtolower;

/**
 * Day of week as defined in ISO-8601 (1 for Monday through 7 for Sunday)
 */
enum DayOfWeek: int
{

    case Monday = 1;
    case Tuesday = 2;
    case Wednesday = 3;
    case Thursday = 4;
    case Friday = 5;
    case Saturday = 6;
    case Sunday = 7;

    public static function getByName(string $name): self
    {
        $name = strtolower($name);
        $number = array_search($name, self::getNames(), true);
        if (!is_int($number)) {
            throw new InvalidValueException($name, static::class);
        }

        return self::from($number);
    }

    /**
     * @return string[]
     */
    public static function getNames(): array
    {
        return [
            self::Monday->value => 'monday',
            self::Tuesday->value => 'tuesday',
            self::Wednesday->value => 'wednesday',
            self::Thursday->value => 'thursday',
            self::Friday->value => 'friday',
            self::Saturday->value => 'saturday',
            self::Sunday->value => 'sunday',
        ];
    }

    /**
     * @return string[]
     */
    public static function getShortcuts(): array
    {
        return [
            self::Monday->value => 'mon',
            self::Tuesday->value => 'tue',
            self::Wednesday->value => 'wed',
            self::Thursday->value => 'thu',
            self::Friday->value => 'fri',
            self::Saturday->value => 'sat',
            self::Sunday->value => 'sun',
        ];
    }

    public function getName(): string
    {
        return self::getNames()[$this->value];
    }

    public function getShortcut(): string
    {
        return self::getShortcuts()[$this->value];
    }

    public function isWeekend(): bool
    {
        $value = $this->value;

        return $value === self::Saturday->value || $value === self::Sunday->value;
    }

}
