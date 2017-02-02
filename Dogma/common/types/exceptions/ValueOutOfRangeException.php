<?php
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma;

class ValueOutOfRangeException extends \Dogma\InvalidValueException
{

    /**
     * @param int|float
     * @param int|float|null
     * @param int|float|null
     * @param \Throwable|null
     */
    public function __construct($value, $min, $max, \Throwable $previous = null)
    {
        if ($min === null) {
            Exception::__construct(
                sprintf('Expected a value lower than %s. Value %s given.', $max, ExceptionValueFormater::format($value)),
                $previous
            );
        } elseif ($max === null) {
            Exception::__construct(
                sprintf('Expected a value higher than %s. Value %s given.', $min, ExceptionValueFormater::format($value)),
                $previous
            );
        } else {
            Exception::__construct(
                sprintf('Expected a value within the range of %s and %s. Value %s given.', $min, $max, ExceptionValueFormater::format($value)),
                $previous
            );
        }
    }

}
