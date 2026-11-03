<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma;

class LineEnding
{
    use StaticClassMixin;

    public const string LF = "\n";
    public const string CRLF = "\r\n";
    public const string CR = "\r";

    public const string LINUX = self::LF;
    public const string WINDOWS = self::CRLF;
    public const string MAC = self::CR;

}
