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
use function sprintf;

class UndefinedPropertyException extends Exception
{

    public function __construct(string $class, string $property, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('Property %s::$%s is not defined or is not accessible', $class, $property), $previous);
    }

}
