<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma;

use Throwable;
use function is_resource;
use function is_scalar;
use function strval;

class InvalidRegularExpressionException extends InvalidValueException
{

    public function __construct(mixed $regexp, ?Throwable $previous = null)
    {
        $value = is_scalar($regexp) || $regexp === null || is_resource($regexp)
            ? strval($regexp)
            : ExceptionValueFormatter::format($regexp);

        Exception::__construct("Value '" . $value . "' is not a valid regular expression.", $previous);
    }

}
