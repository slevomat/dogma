<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Time;

use function in_array;

/**
 * Ať běží rychle a na nic se neptá
 * než bude duše má za chvíli mrtvá
 */
enum DateTimeUnit: string
{

    case Year = 'year';
    case Quarter = 'quarter';
    case Month = 'month';
    case Week = 'week';
    case Day = 'day';

    case Hour = 'hour';
    case Minute = 'minute';
    case Second = 'second';
    case Milisecond = 'milisecond';
    case Microsecond = 'microsecond';

    /**
     * @return string[]
     */
    public static function getDateUnits(): array
    {
        return [
            self::Year->value,
            self::Quarter->value,
            self::Month->value,
            self::Week->value,
            self::Day->value,
        ];
    }

    /**
     * @return string[]
     */
    public static function getTimeUnits(): array
    {
        return [
            self::Hour->value,
            self::Minute->value,
            self::Second->value,
            self::Milisecond->value,
            self::Microsecond->value,
        ];
    }

    /**
     * @return string[]
     */
    public static function getComparisonFormats(): array
    {
        return [
            self::Year->value => 'Y',
            self::Month->value => 'Ym',
            self::Week->value => 'oW',
            self::Day->value => 'Ymd',
            self::Hour->value => 'YmdH',
            self::Minute->value => 'YmdHi',
            self::Second->value => 'YmdHis',
            self::Milisecond->value => 'YmdHisv',
            self::Microsecond->value => 'YmdHisu',
        ];
    }

    public function isDate(): bool
    {
        return in_array($this->value, self::getDateUnits(), true);
    }

    public function isTime(): bool
    {
        return in_array($this->value, self::getTimeUnits(), true);
    }

    /**
     * Used in DateTime::equalsUpTo()
     */
    public function getComparisonFormat(): string
    {
        return self::getComparisonFormats()[$this->value];
    }

}
