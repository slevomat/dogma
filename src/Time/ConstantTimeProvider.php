<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Time;

use Dogma\StrictBehaviorMixin;

class ConstantTimeProvider implements TimeProvider
{
    use StrictBehaviorMixin;

    /** @var \Dogma\Time\DateTime */
    private $dateTime;

    /** @var \DateTimeZone */
    private $timeZone;

    public function __construct(?DateTime $dateTime = null, ?\DateTimeZone $timeZone = null)
    {
        if ($dateTime === null) {
            $dateTime = new DateTime();
        }
        if ($timeZone === null) {
            $timeZone = $dateTime->getTimezone();
        }

        $this->dateTime = $dateTime;
        $this->timeZone = $timeZone;
    }

    public function getDate(): Date
    {
        return $this->dateTime->getDate();
    }

    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }

    public function getTimeZone(): \DateTimeZone
    {
        return $this->timeZone;
    }

}
