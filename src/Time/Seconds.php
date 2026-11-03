<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Time;

use Dogma\StaticClassMixin;

class Seconds
{
    use StaticClassMixin;

    public const int MINUTE = 60;
    public const int HOUR = 3600;
    public const int DAY = 86400;
    public const int WEEK = 604800;
    public const int COMMON_YEAR = 31536000;
    public const int LEAP_YEAR = 31622400;

}
