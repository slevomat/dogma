<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Time;

use Dogma\Check;
use Dogma\NonIterable;
use Dogma\NonIterableMixin;
use Dogma\Str;
use Dogma\StrictBehaviorMixin;
use Dogma\Type;

/**
 * Immutable date and time class
 */
class DateTime extends \DateTimeImmutable implements NonIterable, \DateTimeInterface
{
    use StrictBehaviorMixin;
    use NonIterableMixin;

    public const DEFAULT_FORMAT = 'Y-m-d H:i:s';
    public const FORMAT_EMAIL_HTTP = DATE_RFC2822;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param string $format
     * @param string $timeString
     * @param \DateTimeZone|null $timeZone
     * @return \Dogma\Time\DateTime
     */
    public static function createFromFormat($format, $timeString, $timeZone = null): self
    {
        // due to invalid typehint in parent class...
        Check::nullableObject($timeZone, \DateTimeZone::class);

        // due to invalid optional arguments handling...
        if ($timeZone === null) {
            $dateTime = parent::createFromFormat($format, $timeString);
        } else {
            $dateTime = parent::createFromFormat($format, $timeString, $timeZone);
        }

        return new static($dateTime->format(self::DEFAULT_FORMAT), $timeZone ?? $dateTime->getTimezone());
    }

    public static function createFromTimestamp(int $timestamp, ?\DateTimeZone $timeZone = null): self
    {
        return static::createFromFormat('U', (string) $timestamp, $timeZone);
    }

    public static function createFromDateTimeInterface(\DateTimeInterface $dateTime, ?\DateTimeZone $timeZone = null): self
    {
        if ($timeZone === null) {
            $timeZone = $dateTime->getTimezone();
        }
        return new static($dateTime->format(self::DEFAULT_FORMAT), $timeZone);
    }

    public static function createFromDateAndTime(Date $date, Time $time, ?\DateTimeZone $timeZone = null): self
    {
        return new static($date->format(Date::DEFAULT_FORMAT) . ' ' . $time->format(Time::DEFAULT_FORMAT), $timeZone);
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param string $modify
     * @return static
     */
    public function modify($modify): self
    {
        return new static(parent::modify($modify));
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param string $format
     * @return string
     */
    public function format($format = self::DEFAULT_FORMAT): string
    {
        return parent::format($format);
    }

    public function getDate(): Date
    {
        return new Date($this->format(Date::DEFAULT_FORMAT));
    }

    public function getTime(): Time
    {
        return new Time($this->format(Time::DEFAULT_FORMAT));
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \Dogma\Time\Time|int|string $time
     * @param int|null $minutes
     * @param int|null $seconds
     * @param int|null $microseconds
     * @return self
     */
    public function setTime($time, $minutes = null, $seconds = null, $microseconds = null): self
    {
        if ($time instanceof Time) {
            return self::createFromDateTimeInterface(parent::setTime($time->getHours(), $time->getMinutes(), $time->getSeconds()));
        }
        if ($minutes === null && $seconds === null && is_string($time) && Str::contains($time, ':')) {
            @list($time, $minutes, $seconds) = explode(':', $time);
            if (Str::contains($seconds, '.')) {
                @list($seconds, $microseconds) = explode('.', $seconds);
                $microseconds = (int) (('0.' . $microseconds) * 1000000);
            }
        }

        return self::createFromDateTimeInterface(parent::setTime((int) $time, (int) $minutes, (int) $seconds, (int) $microseconds));
    }

    public function compare(\DateTimeInterface $dateTime): int
    {
        return $this > $dateTime ? 1 : ($dateTime > $this ? -1 : 0);
    }

    public function isEqual(\DateTimeInterface $dateTime): bool
    {
        return $this->getTimestamp() === $dateTime->getTimestamp();
    }

    public function isBefore(\DateTimeInterface $dateTime): bool
    {
        return $this < $dateTime;
    }

    public function isAfter(\DateTimeInterface $dateTime): bool
    {
        return $this > $dateTime;
    }

    public function isBetween(\DateTimeInterface $sinceTime, \DateTimeInterface $untilTime): bool
    {
        return $this >= $sinceTime && $this <= $untilTime;
    }

    public function isFuture(?TimeProvider $timeProvider = null): bool
    {
        return $this > ($timeProvider !== null ? $timeProvider->getDateTime() : new self());
    }

    public function isPast(?TimeProvider $timeProvider = null): bool
    {
        return $this < ($timeProvider !== null ? $timeProvider->getDateTime() : new self());
    }

    /**
     * @param \DateTimeInterface|\Dogma\Time\Date $date
     * @return bool
     */
    public function isSameDay($date): bool
    {
        Check::types($date, [\DateTimeInterface::class, Date::class]);

        return $this->format(Date::DEFAULT_FORMAT) === $date->format(Date::DEFAULT_FORMAT);
    }

    /**
     * @param \DateTimeInterface|\Dogma\Time\Date $date
     * @return bool
     */
    public function isBeforeDay($date): bool
    {
        Check::types($date, [\DateTimeInterface::class, Date::class]);

        return $this->format(Date::DEFAULT_FORMAT) < $date->format(Date::DEFAULT_FORMAT);
    }

    /**
     * @param \DateTimeInterface|\Dogma\Time\Date $date
     * @return bool
     */
    public function isAfterDay($date): bool
    {
        Check::types($date, [\DateTimeInterface::class, Date::class]);

        return $this->format(Date::DEFAULT_FORMAT) > $date->format(Date::DEFAULT_FORMAT);
    }

    /**
     * @param \DateTimeInterface|\Dogma\Time\Date $sinceDate
     * @param \DateTimeInterface|\Dogma\Time\Date $untilDate
     * @return bool
     */
    public function isBetweenDays($sinceDate, $untilDate): bool
    {
        Check::types($sinceDate, [\DateTimeInterface::class, Date::class]);
        Check::types($untilDate, [\DateTimeInterface::class, Date::class]);

        $thisDate = $this->format(Date::DEFAULT_FORMAT);

        return $thisDate >= $sinceDate->format(Date::DEFAULT_FORMAT)
            && $thisDate <= $untilDate->format(Date::DEFAULT_FORMAT);
    }

    public function isToday(?TimeProvider $timeProvider = null): bool
    {
        $today = $timeProvider !== null ? $timeProvider->getDate() : new Date('today');

        return $this->isBetween($today->getStart(), $today->getEnd());
    }

    public function isYesterday(?TimeProvider $timeProvider = null): bool
    {
        $yesterday = $timeProvider !== null ? $timeProvider->getDateTime()->modify('-1 day')->getDate() : new Date('yesterday');

        return $this->isBetween($yesterday->getStart(), $yesterday->getEnd());
    }

    public function isTomorrow(?TimeProvider $timeProvider = null): bool
    {
        $tomorrow = $timeProvider !== null ? $timeProvider->getDateTime()->modify('+1 day')->getDate() : new Date('tomorrow');

        return $this->isBetween($tomorrow->getStart(), $tomorrow->getEnd());
    }

    public function getDayOfWeekEnum(): DayOfWeek
    {
        return DayOfWeek::get((int) $this->format('N'));
    }

    /**
     * @param int|\Dogma\Time\DayOfWeek $day
     * @return bool
     */
    public function isDayOfWeek($day): bool
    {
        Check::types($day, [Type::INT, DayOfWeek::class]);

        if (is_int($day)) {
            $day = DayOfWeek::get($day);
        }

        return (int) $this->format('N') === $day->getValue();
    }

    public function isWeekend(): bool
    {
        return $this->format('N') > 5;
    }

    public function getMonthEnum(): Month
    {
        return Month::get((int) $this->format('n'));
    }

    /**
     * @param int|\Dogma\Time\Month $month
     * @return bool
     */
    public function isMonth($month): bool
    {
        Check::types($month, [Type::INT, Month::class]);

        if (is_int($month)) {
            $month = Month::get($month);
        }

        return (int) $this->format('n') === $month->getValue();
    }

}