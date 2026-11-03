<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\System;

use Dogma\Arr;

enum Sapi: string
{

    case AolServer = 'aolserver';
    case Apache = 'apache';
    case Apache2Filter = 'apache2filter';
    case Apache2Handler = 'apache2handler';
    case Caudium = 'caudium';
    case Cgi = 'cgi'; // (until PHP 5.3)
    case CgiFcgi = 'cgi-fcgi';
    case Cli = 'cli';
    case CliServer = 'cli-server';
    case Continuity = 'continuity';
    case Embed = 'embed';
    case FpmFcgi = 'fpm-fcgi';
    case Isapi = 'isapi';
    case Litespeed = 'litespeed';
    case Milter = 'milter';
    case Nsapi = 'nsapi';
    case Phttpd = 'phttpd';
    case Pi3web = 'pi3web';
    case Roxen = 'roxen';
    case Thttpd = 'thttpd';
    case Tux = 'tux';
    case Webjames = 'webjames';

    private const array MULTITHREADED = [
        self::AolServer->value,
        self::Apache->value,
        self::Apache2Filter->value,
        self::Apache2Handler->value,
        self::Caudium->value,
        self::Continuity->value,
        self::Isapi->value,
        self::Litespeed->value,
        self::Milter->value,
        self::Nsapi->value,
        self::Phttpd->value,
        self::Pi3web->value,
        self::Roxen->value,
        self::Thttpd->value,
        self::Tux->value,
        self::Webjames->value,
    ];

    public function isCli(): bool
    {
        return $this->value === self::Cli->value;
    }

    public function isMultithreaded(): bool
    {
        return Arr::contains(self::MULTITHREADED, $this->value);
    }

}
