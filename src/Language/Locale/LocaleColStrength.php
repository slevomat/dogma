<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md'; distributed with this source code
 */

namespace Dogma\Language\Locale;

use Collator;
use function strtolower;

enum LocaleColStrength: string implements LocaleCollationOption
{

    case Primary = 'primary';
    case Secondary = 'secondary';
    case Tertiary = 'tertiary';
    case Quaternary = 'quaternary';
    case Identical = 'identical';

    public static function parse(string $value): self
    {
        return self::from(strtolower($value));
    }

    public function getCollatorValue(): int
    {
        return [
            self::Primary->value => Collator::PRIMARY,
            self::Secondary->value => Collator::SECONDARY,
            self::Tertiary->value => Collator::TERTIARY,
            self::Quaternary->value => Collator::TERTIARY,
            self::Identical->value => Collator::IDENTICAL,
        ][$this->value];
    }

}
