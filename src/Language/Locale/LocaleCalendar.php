<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md'; distributed with this source code
 */

// spell-check-ignore: roc

namespace Dogma\Language\Locale;

use function strtolower;

enum LocaleCalendar: string
{

    case Buddhist = 'buddhist';
    case Chinese = 'chinese';
    case Coptic = 'coptic';
    case Dangi = 'dangi';
    case Ethiopic = 'ethiopic';
    case EthiopicAmeteAlem = 'ethiopic-amete-alem';
    case Gregorian = 'gregorian';
    case Hebrew = 'hebrew';
    case Indian = 'indian';
    case Islamic = 'islamic';
    case IslamicCivil = 'islamic-civil';
    case Iso8601 = 'iso8601';
    case Japanese = 'japanese';
    case Persian = 'persian';
    case Roc = 'roc';

    public static function parse(string $value): self
    {
        return self::from(strtolower($value));
    }

}
