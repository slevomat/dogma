<?php declare(strict_types = 1);

namespace Dogma\Tests\Time\Interval;

use Dogma\NotImplementedException;
use Dogma\Tester\Assert;
use Dogma\Time\DateTimeUnit;
use Dogma\Time\Interval\DateTimeInterval;

require_once __DIR__ . '/../../bootstrap.php';

$i = static function (string $i): DateTimeInterval {
    return DateTimeInterval::createFromString($i);
};
$s = static function (string ...$is): array {
    return array_map(static function (string $interval) {
        return DateTimeInterval::createFromString($interval);
    }, $is);
};


year:
Assert::equal($i('2000-05-05 00:00 - 2000-06-05 00:00')->splitByUnitAligned(DateTimeUnit::Year), $s(
    '2000-05-05 00:00 - 2000-06-05 00:00'
));
Assert::equal($i('2000-05-05 00:00 - 2001-05-05 00:00')->splitByUnitAligned(DateTimeUnit::Year), $s(
    '2000-05-05 00:00 - 2001-01-01 00:00',
    '2001-01-01 00:00 - 2001-05-05 00:00'
));
Assert::equal($i('2000-05-05 00:00 - 2003-05-05 00:00')->splitByUnitAligned(DateTimeUnit::Year, 2), $s(
    '2000-05-05 00:00 - 2002-01-01 00:00',
    '2002-01-01 00:00 - 2003-05-05 00:00'
));
Assert::equal($i('2000-05-05 00:00 - 2001-10-05 00:00')->splitByUnit(DateTimeUnit::Year), $s(
    '2000-05-05 00:00 - 2001-05-05 00:00',
    '2001-05-05 00:00 - 2001-10-05 00:00'
));


quarter:
Assert::equal($i('2000-01-05 00:00 - 2000-01-06 00:00')->splitByUnitAligned(DateTimeUnit::Quarter), $s(
    '2000-01-05 00:00 - 2000-01-06 00:00'
));
Assert::equal($i('2000-01-05 00:00 - 2000-05-05 00:00')->splitByUnitAligned(DateTimeUnit::Quarter), $s(
    '2000-01-05 00:00 - 2000-04-01 00:00',
    '2000-04-01 00:00 - 2000-05-05 00:00'
));
Assert::throws(static function () use ($i): void {
    $i('2000-01-05 00:00 - 2000-08-05 00:00')->splitByUnitAligned(DateTimeUnit::Quarter, 2);
}, NotImplementedException::class);
Assert::equal($i('2000-01-05 00:00 - 2000-05-05 00:00')->splitByUnit(DateTimeUnit::Quarter), $s(
    '2000-01-05 00:00 - 2000-04-05 00:00',
    '2000-04-05 00:00 - 2000-05-05 00:00'
));


month:
Assert::equal($i('2000-01-05 00:00 - 2000-01-06 00:00')->splitByUnitAligned(DateTimeUnit::Month), $s(
    '2000-01-05 00:00 - 2000-01-06 00:00'
));
Assert::equal($i('2000-01-05 00:00 - 2000-02-05 00:00')->splitByUnitAligned(DateTimeUnit::Month), $s(
    '2000-01-05 00:00 - 2000-02-01 00:00',
    '2000-02-01 00:00 - 2000-02-05 00:00'
));
Assert::equal($i('2000-01-05 00:00 - 2000-04-05 00:00')->splitByUnitAligned(DateTimeUnit::Month, 2), $s(
    '2000-01-05 00:00 - 2000-03-01 00:00',
    '2000-03-01 00:00 - 2000-04-05 00:00'
));
Assert::equal($i('2000-01-05 00:00 - 2000-02-05 00:00')->splitByUnit(DateTimeUnit::Month), $s(
    '2000-01-05 00:00 - 2000-02-05 00:00'
));


week:
Assert::equal($i('2000-01-01 00:00 - 2000-01-02 00:00')->splitByUnitAligned(DateTimeUnit::Week), $s(
    '2000-01-01 00:00 - 2000-01-02 00:00'
));
Assert::equal($i('2000-01-01 00:00 - 2000-01-07 00:00')->splitByUnitAligned(DateTimeUnit::Week), $s(
    '2000-01-01 00:00 - 2000-01-03 00:00',
    '2000-01-03 00:00 - 2000-01-07 00:00'
));
Assert::equal($i('2000-01-01 00:00 - 2000-01-14 00:00')->splitByUnitAligned(DateTimeUnit::Week, 2), $s(
    // because last week of previous year is matched as reference
    '2000-01-01 00:00 - 2000-01-03 00:00',
    '2000-01-03 00:00 - 2000-01-14 00:00'
));
Assert::equal($i('2000-01-01 00:00 - 2000-01-12 00:00')->splitByUnit(DateTimeUnit::Week), $s(
    '2000-01-01 00:00 - 2000-01-08 00:00',
    '2000-01-08 00:00 - 2000-01-12 00:00'
));


day:
Assert::equal($i('2000-01-01 12:00 - 2000-01-01 13:00')->splitByUnitAligned(DateTimeUnit::Day), $s(
    '2000-01-01 12:00 - 2000-01-01 13:00'
));
Assert::equal($i('2000-01-01 12:00 - 2000-01-02 12:00')->splitByUnitAligned(DateTimeUnit::Day), $s(
    '2000-01-01 12:00 - 2000-01-02 00:00',
    '2000-01-02 00:00 - 2000-01-02 12:00'
));
Assert::equal($i('2000-01-01 12:00 - 2000-01-04 12:00')->splitByUnitAligned(DateTimeUnit::Day, 2), $s(
    '2000-01-01 12:00 - 2000-01-03 00:00',
    '2000-01-03 00:00 - 2000-01-04 12:00'
));
Assert::equal($i('2000-01-01 12:00 - 2000-01-02 12:00')->splitByUnit(DateTimeUnit::Day), $s(
    '2000-01-01 12:00 - 2000-01-02 12:00'
));


hour:
Assert::equal($i('2000-01-01 00:12 - 2000-01-01 00:13')->splitByUnitAligned(DateTimeUnit::Hour), $s(
    '2000-01-01 00:12 - 2000-01-01 00:13'
));
Assert::equal($i('2000-01-01 00:12 - 2000-01-01 01:12')->splitByUnitAligned(DateTimeUnit::Hour), $s(
    '2000-01-01 00:12 - 2000-01-01 01:00',
    '2000-01-01 01:00 - 2000-01-01 01:12'
));
Assert::equal($i('2000-01-01 00:12 - 2000-01-01 03:12')->splitByUnitAligned(DateTimeUnit::Hour, 2), $s(
    '2000-01-01 00:12 - 2000-01-01 02:00',
    '2000-01-01 02:00 - 2000-01-01 03:12'
));
Assert::equal($i('2000-01-01 00:12 - 2000-01-01 01:12')->splitByUnit(DateTimeUnit::Hour), $s(
    '2000-01-01 00:12 - 2000-01-01 01:12'
));


minute:
Assert::equal($i('2000-01-01 00:00:12 - 2000-01-01 00:00:13')->splitByUnitAligned(DateTimeUnit::Minute), $s(
    '2000-01-01 00:00:12 - 2000-01-01 00:00:13'
));
Assert::equal($i('2000-01-01 00:00:12 - 2000-01-01 00:01:12')->splitByUnitAligned(DateTimeUnit::Minute), $s(
    '2000-01-01 00:00:12 - 2000-01-01 00:01:00',
    '2000-01-01 00:01:00 - 2000-01-01 00:01:12'
));
Assert::equal($i('2000-01-01 00:00:12 - 2000-01-01 00:03:12')->splitByUnitAligned(DateTimeUnit::Minute, 2), $s(
    '2000-01-01 00:00:12 - 2000-01-01 00:02:00',
    '2000-01-01 00:02:00 - 2000-01-01 00:03:12'
));
Assert::equal($i('2000-01-01 00:00:12 - 2000-01-01 00:01:12')->splitByUnit(DateTimeUnit::Minute), $s(
    '2000-01-01 00:00:12 - 2000-01-01 00:01:12'
));


second:
Assert::equal($i('2000-01-01 00:00:00.12 - 2000-01-01 00:00:00.13')->splitByUnitAligned(DateTimeUnit::Second), $s(
    '2000-01-01 00:00:00.12 - 2000-01-01 00:00:00.13'
));
Assert::equal($i('2000-01-01 00:00:00.12 - 2000-01-01 00:00:01.12')->splitByUnitAligned(DateTimeUnit::Second), $s(
    '2000-01-01 00:00:00.12 - 2000-01-01 00:00:01',
    '2000-01-01 00:00:01 - 2000-01-01 00:00:01.12'
));
Assert::equal($i('2000-01-01 00:00:00.12 - 2000-01-01 00:00:03.12')->splitByUnitAligned(DateTimeUnit::Second, 2), $s(
    '2000-01-01 00:00:00.12 - 2000-01-01 00:00:02',
    '2000-01-01 00:00:02 - 2000-01-01 00:00:03.12'
));
Assert::equal($i('2000-01-01 00:00:00.12 - 2000-01-01 00:00:01.12')->splitByUnit(DateTimeUnit::Second), $s(
    '2000-01-01 00:00:00.12 - 2000-01-01 00:00:01.12'
));


milisecond:
Assert::equal($i('2000-01-01 00:00:00.000012 - 2000-01-01 00:00:00.000013')->splitByUnitAligned(DateTimeUnit::Milisecond), $s(
    '2000-01-01 00:00:00.000012 - 2000-01-01 00:00:00.000013'
));
Assert::equal($i('2000-01-01 00:00:00.000012 - 2000-01-01 00:00:00.001012')->splitByUnitAligned(DateTimeUnit::Milisecond), $s(
    '2000-01-01 00:00:00.000012 - 2000-01-01 00:00:00.001',
    '2000-01-01 00:00:00.001 - 2000-01-01 00:00:00.001012'
));
Assert::equal($i('2000-01-01 00:00:00.000012 - 2000-01-01 00:00:00.003012')->splitByUnitAligned(DateTimeUnit::Milisecond, 2), $s(
    '2000-01-01 00:00:00.000012 - 2000-01-01 00:00:00.002',
    '2000-01-01 00:00:00.002 - 2000-01-01 00:00:00.003012'
));
Assert::equal($i('2000-01-01 00:00:00.000012 - 2000-01-01 00:00:00.001012')->splitByUnit(DateTimeUnit::Milisecond), $s(
    '2000-01-01 00:00:00.000012 - 2000-01-01 00:00:00.001012'
));


microsecond:
Assert::equal($i('2000-01-01 00:00:00.000001 - 2000-01-01 00:00:00.000003')->splitByUnitAligned(DateTimeUnit::Microsecond), $s(
    '2000-01-01 00:00:00.000001 - 2000-01-01 00:00:00.000002',
    '2000-01-01 00:00:00.000002 - 2000-01-01 00:00:00.000003'
));
Assert::equal($i('2000-01-01 00:00:00.000001 - 2000-01-01 00:00:00.000020')->splitByUnitAligned(DateTimeUnit::Microsecond, 10), $s(
    '2000-01-01 00:00:00.000001 - 2000-01-01 00:00:00.000010',
    '2000-01-01 00:00:00.000010 - 2000-01-01 00:00:00.000020'
));
Assert::equal($i('2000-01-01 00:00:00.000001 - 2000-01-01 00:00:00.000003')->splitByUnit(DateTimeUnit::Microsecond), $s(
    '2000-01-01 00:00:00.000001 - 2000-01-01 00:00:00.000002',
    '2000-01-01 00:00:00.000002 - 2000-01-01 00:00:00.000003'
));
Assert::equal($i('2000-01-01 00:00:00.000001 - 2000-01-01 00:00:00.000020')->splitByUnit(DateTimeUnit::Microsecond, 10), $s(
    '2000-01-01 00:00:00.000001 - 2000-01-01 00:00:00.000011',
    '2000-01-01 00:00:00.000011 - 2000-01-01 00:00:00.000020'
));
