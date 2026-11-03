<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md'; distributed with this source code
 */

namespace Dogma\Language\Locale;

use function strtolower;

enum LocaleNumbers: string
{

    case ArabicIndic = 'arab';
    case EstendedArabicIndic = 'arabext';
    case Armenian = 'armn';
    case ArmenianLowercase = 'armnlow';
    case Balinese = 'bali';
    case Bengali = 'beng';
    case Devanagari = 'deva';
    case Ethiopic = 'ethi';
    case Financial = 'finance';
    case FullWidth = 'fullwide';
    case Georgian = 'geor';
    case Greek = 'grek';
    case GreekLowercase = 'greklow';
    case Gujarati = 'gujr';
    case Gurmukhi = 'guru';
    case ChineseDecimal = 'hanidec';
    case SimplifiesChinese = 'hans';
    case SimplifiesChineseFinancial = 'hansfin';
    case TraditionalChinese = 'hant';
    case TraditionalChineseFinancial = 'hantfin';
    case Hebrew = 'hebr';
    case Javanese = 'java';
    case Japanese = 'jpan';
    case JapaneseFinancial = 'jpanfin';
    case Khmer = 'khmr';
    case Kannada = 'knda';
    case Lao = 'laoo';
    case Western = 'latn';
    case Malayalan = 'mlym';
    case Mongolian = 'mong';
    case Myanmar = 'mymr';
    case Native = 'native';
    case Oriya = 'orya';
    case Osmanya = 'osma';
    case Roman = 'roman';
    case RomanLowercase = 'romanlow';
    case Saurashtra = 'saur';
    case Sundanese = 'sund';
    case TraditionalTamil = 'taml';
    case Tamil = 'tamldec';
    case Telugu = 'telu';
    case Thai = 'thai';
    case Tibetan = 'tibt';
    case Traditional = 'traditional';
    case Vai = 'vaii';

    public static function parse(string $value): self
    {
        return self::from(strtolower($value));
    }

}
