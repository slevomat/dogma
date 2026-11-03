<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma;

class IntersectResult
{
    use StaticClassMixin;

    // a---a   b---b
    public const int BEFORE_START = -6;
    // a---ab---b
    public const int TOUCHES_START = -5;
    // a---b---a---b
    public const int INTERSECTS_START = -4;

    // a---b---ab
    public const int EXTENDS_START = -3;
    // a---b---b---a
    public const int CONTAINS = -2;
    // ab---a---b
    public const int FITS_TO_START = -1;

    // ab---ab
    public const int SAME = 0;

    // b---a---ab
    public const int FITS_TO_END = 1;
    // b---a---a---b
    public const int IS_CONTAINED = 2;
    // ab---b---a
    public const int EXTENDS_END = 3;

    // b---a---b---a
    public const int INTERSECTS_END = 4;
    // b---ab---a
    public const int TOUCHES_END = 5;
    // b---b   a---a
    public const int AFTER_END = 6;

}
