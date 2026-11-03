<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma;

use const SORT_NATURAL;
use const SORT_NUMERIC;
use const SORT_REGULAR;
use const SORT_STRING;

class Sorting
{
    use StaticClassMixin;

    public const int REGULAR = SORT_REGULAR;
    public const int NUMERIC = SORT_NUMERIC;
    public const int STRING = SORT_STRING;
    public const int NATURAL = SORT_NATURAL;

}
