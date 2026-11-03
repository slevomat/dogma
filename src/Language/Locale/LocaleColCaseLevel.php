<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md'; distributed with this source code
 */

namespace Dogma\Language\Locale;

use Dogma\Language\Collator;
use function strtolower;

enum LocaleColCaseLevel: string implements LocaleCollationOption
{

    case Yes = 'yes';
    case No = 'no';

    public static function parse(string $value): self
    {
        return self::from(strtolower($value));
    }

    public function getCollatorValue(): int
    {
        return [
            self::Yes->value => Collator::ON,
            self::No->value => Collator::OFF,
        ][$this->value];
    }

}
