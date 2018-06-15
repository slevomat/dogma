<?php

namespace Dogma\Tests\Math\Interval;

use Dogma\Tester\Assert;
use Dogma\Time\Date;
use Dogma\Time\Interval\DateInterval;
use Dogma\Time\Interval\DateIntervalSet;

require_once __DIR__ . '/../../bootstrap.php';

$d = function (int $day) {
    return Date::createFromComponents(2000, 1, $day);
};
$i = function (int $start, int $end) use ($d) {
    return new DateInterval($d($start), $d($end));
};
$s = function (DateInterval ...$items) {
    return new DateIntervalSet($items);
};

$interval = new DateInterval($d(1), $d(5));
$emptyInterval = DateInterval::empty();

$set = new DateIntervalSet([$interval]);

// isEmpty()
Assert::true((new DateIntervalSet([]))->isEmpty());
Assert::true((new DateIntervalSet([$emptyInterval]))->isEmpty());

// equals()
Assert::true($set->equals($s($i(1, 5))));
Assert::false($set->equals($s($i(1, 6))));

// containsValue()
Assert::true($set->containsValue($d(1)));
Assert::true($set->containsValue($d(5)));
Assert::false($set->containsValue($d(6)));

// envelope()
Assert::equal($s($i(1, 2), $i(4, 5))->envelope(), $interval);

// normalize()
Assert::equal($s($i(1, 4), $i(2, 5))->normalize(), $set);

// add()
Assert::equal($s($i(1, 2), $i(3, 4), $i(5, 6)), $s($i(1, 2))->add($s($i(3, 4), $i(5, 6))));

// subtract()
Assert::equal($s($i(1, 10))->subtract($s($i(3, 4), $i(7, 8))), $s($i(1, 2), $i(5, 6), $i(9, 10)));

// intersect()
Assert::equal($s($i(1, 5), $i(10, 15))->intersect($s($i(4, 12), $i(14, 20))), $s($i(4, 5), $i(10, 12), $i(14, 15)));