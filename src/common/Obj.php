<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

// phpcs:disable SlevomatCodingStandard.TypeHints.ParameterTypeHint

namespace Dogma;

use function is_object;
use function md5;
use function spl_object_id;
use function substr;

class Obj
{
    use StaticClassMixin;

    public static function dumpHash(object $object): string
    {
        return substr(md5((string) spl_object_id($object)), 0, 4);
    }

    /**
     * @param object|resource $object
     */
    public static function objectId($object): int
    {
        if (is_object($object)) {
            return spl_object_id($object);
        } else {
            return (int) $object;
        }
    }

}
