<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

// spell-check-ignore: jan feb apr jul aug sep oct nov dec

namespace Dogma\Time;

use Dogma\InvalidValueException;
use function array_search;
use function is_int;
use function strtolower;

enum Month: int
{

    case January = 1;
    case February = 2;
    case March = 3;
    case April = 4;
    case May = 5;
    case June = 6;
    case July = 7;
    case August = 8;
    case September = 9;
    case October = 10;
    case November = 11;
    case December = 12;

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
            self::January->value => 'january',
            self::February->value => 'february',
            self::March->value => 'march',
            self::April->value => 'april',
            self::May->value => 'may',
            self::June->value => 'june',
            self::July->value => 'july',
            self::August->value => 'august',
            self::September->value => 'september',
            self::October->value => 'october',
            self::November->value => 'november',
            self::December->value => 'december',
        ];
    }

    /**
     * @return string[]
     */
    public static function getShortcuts(): array
    {
        return [
            self::January->value => 'jan',
            self::February->value => 'feb',
            self::March->value => 'mar',
            self::April->value => 'apr',
            self::May->value => 'may',
            self::June->value => 'jun',
            self::July->value => 'jul',
            self::August->value => 'aug',
            self::September->value => 'sep',
            self::October->value => 'oct',
            self::November->value => 'nov',
            self::December->value => 'dec',
        ];
    }

    /**
     * @return int[]
     */
    public static function getLengths(bool $leapYear = false): array
    {
        return $leapYear
            ? [
                self::January->value => 31,
                self::February->value => 29,
                self::March->value => 31,
                self::April->value => 30,
                self::May->value => 31,
                self::June->value => 30,
                self::July->value => 31,
                self::August->value => 31,
                self::September->value => 30,
                self::October->value => 31,
                self::November->value => 30,
                self::December->value => 31,
            ] : [
                self::January->value => 31,
                self::February->value => 28,
                self::March->value => 31,
                self::April->value => 30,
                self::May->value => 31,
                self::June->value => 30,
                self::July->value => 31,
                self::August->value => 31,
                self::September->value => 30,
                self::October->value => 31,
                self::November->value => 30,
                self::December->value => 31,
            ];
    }

    /**
     * @return int[]
     */
    public static function getLengthsForYear(int $year): array
    {
        $leapYear = ($year % 4) === 0 && (($year % 100) !== 0 || ($year % 400) === 0);

        return self::getLengths($leapYear);
    }

    public function getName(): string
    {
        return self::getNames()[$this->value];
    }

    public function getShortcut(): string
    {
        return self::getShortcuts()[$this->value];
    }

    public function getDays(bool $leapYear): int
    {
        return self::getLengths($leapYear)[$this->value];
    }

    public function getDaysForYear(int $year): int
    {
        $leapYear = ($year % 4) === 0 && (($year % 100) !== 0 || ($year % 400) === 0);

        return self::getLengths($leapYear)[$this->value];
    }

}
