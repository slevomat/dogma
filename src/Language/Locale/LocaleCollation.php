<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md'; distributed with this source code
 */

// spell-check-ignore: big5han ducet eor phonebook searchjl unihan zhuyin Ducet Phonebook Searchjl Unihan Zhuyin

namespace Dogma\Language\Locale;

use function strtolower;

enum LocaleCollation: string
{

    case Big5 = 'big5han';
    case Dictionary = 'dictionary';
    case Ducet = 'ducet';
    case Eor = 'eor';
    case Gb2312 = 'gb2312han';
    case Phonebook = 'phonebook';
    case Phonetic = 'phonetic';
    case Pinyin = 'pinyin';
    case Reformed = 'reformed';
    case Search = 'search';
    case Searchjl = 'searchjl';
    case Standard = 'standard';
    case Stoke = 'stroke';
    case Traditional = 'traditional';
    case Unihan = 'unihan';
    case Zhuyin = 'zhuyin';

    public static function parse(string $value): self
    {
        return self::from(strtolower($value));
    }

}
