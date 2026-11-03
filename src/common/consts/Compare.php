<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma;

class Compare
{
    use StaticClassMixin;

    public const string LESSER = '<';
    public const string LESSER_OR_EQUAL = '<=';
    public const string EQUAL = '=';
    public const string NOT_EQUAL = '<>';
    public const string GREATER_OR_EQUAL = '>=';
    public const string GREATER = '>';

}
