<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\System;

use const PHP_OS;

/**
 * PHP_OS_FAMILY values (PHP 7.2+)
 */
enum Os: string
{

    case Windows = 'Windows';
    case Bsd = 'BSD';
    case Darwin = 'Darwin';
    case Solaris = 'Solaris';
    case Linux = 'Linux';
    case Unknown = 'Unknown';

    private const array FAMILIES = [
        'CYGWIN_NT-5.1' => self::Windows->value,
        'Darwin' => self::Darwin->value,
        'FreeBSD' => self::Bsd->value,
        'HP-UX' => self::Unknown->value,
        'IRIX64' => self::Unknown->value,
        'Linux' => self::Linux->value,
        'NetBSD' => self::Bsd->value,
        'OpenBSD' => self::Bsd->value,
        'SunOS' => self::Solaris->value,
        'Unix' => self::Unknown->value,
        'WIN32' => self::Windows->value,
        'WINNT' => self::Windows->value,
        'Windows' => self::Windows->value,
    ];

    public static function family(): string
    {
        return self::FAMILIES[PHP_OS] ?? self::Unknown->value;
    }

    public static function isWindows(): bool
    {
        return self::family() === self::Windows->value;
    }

}
