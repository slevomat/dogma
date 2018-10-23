<?php declare(strict_types = 1);

namespace Dogma\Tests\Time\Interval;

use Dogma\Tester\Assert;
use Dogma\Time\Date;
use Dogma\Time\Interval\NightInterval;
use Dogma\Time\Interval\NightIntervalSet;

require_once __DIR__ . '/../../bootstrap.php';

$d = function (int $day): Date {
    return Date::createFromComponents(2000, 1, $day);
};
$i = function (int $start, int $end) use ($d): NightInterval {
    return new NightInterval($d($start), $d($end));
};
$s = function (NightInterval ...$items): NightIntervalSet {
    return new NightIntervalSet($items);
};

$interval = new NightInterval($d(1), $d(6));
$emptyInterval = NightInterval::empty();

$set = new NightIntervalSet([$interval]);

// createFromDateArray()
Assert::equal(NightIntervalSet::createFromDateArray([]), $s());
Assert::equal(NightIntervalSet::createFromDateArray([$d(1), $d(2), $d(3), $d(4), $d(5)]), $s($interval));
Assert::equal(NightIntervalSet::createFromDateArray([$d(1), $d(2), $d(4), $d(5)]), $s($i(1, 3), $i(4, 6)));

// toDateArray()
Assert::equal($emptyInterval->toDateArray(), []);
Assert::equal($interval->toDateArray(), [$d(1), $d(2), $d(3), $d(4), $d(5)]);
Assert::equal($s($i(1, 3), $i(4, 6))->toDateArray(), [$d(1), $d(2), $d(4), $d(5)]);

// isEmpty()
Assert::true((new NightIntervalSet([]))->isEmpty());
Assert::true((new NightIntervalSet([$emptyInterval]))->isEmpty());

// equals()
Assert::false($set->equals($s($i(1, 5))));
Assert::true($set->equals($s($i(1, 6))));
Assert::false($set->equals($s($i(1, 7))));

// containsValue()
Assert::true($set->containsValue($d(1)));
Assert::true($set->containsValue($d(5)));
Assert::false($set->containsValue($d(6)));

// envelope()
Assert::equal($s($i(1, 3), $i(4, 6))->envelope(), $interval);

// normalize()
Assert::equal($s($i(1, 4), $i(2, 6))->normalize(), $set);

// add()
Assert::equal($s($i(1, 3), $i(3, 5), $i(5, 7)), $s($i(1, 3))->add($s($i(3, 5), $i(5, 7))));

// subtract()
Assert::equal($s($i(1, 11))->subtract($s($i(3, 5), $i(7, 9))), $s($i(1, 3), $i(5, 7), $i(9, 11)));

// intersect()
Assert::equal($s($i(1, 5), $i(10, 15))->intersect($s($i(4, 12), $i(14, 20))), $s($i(4, 5), $i(10, 12), $i(14, 15)));

$set = $s($emptyInterval, $i(1, 2), $i(1, 3), $i(1, 4));

// filterByLength()
Assert::equal($set->filterByLength('>', 1), $s($i(1, 3), $i(1, 4)));
Assert::equal($set->filterByLength('>=', 1), $s($i(1, 2), $i(1, 3), $i(1, 4)));
Assert::equal($set->filterByLength('=', 1), $s($i(1, 2)));
Assert::equal($set->filterByLength('<>', 1), $s($emptyInterval, $i(1, 3), $i(1, 4)));
Assert::equal($set->filterByLength('<=', 1), $s($emptyInterval, $i(1, 2)));
Assert::equal($set->filterByLength('<', 1), $s($emptyInterval));

// filterByCount()
Assert::equal($set->filterByNightsCount('>', 1), $s($i(1, 3), $i(1, 4)));
Assert::equal($set->filterByNightsCount('>=', 1), $s($i(1, 2), $i(1, 3), $i(1, 4)));
Assert::equal($set->filterByNightsCount('=', 1), $s($i(1, 2)));
Assert::equal($set->filterByNightsCount('<>', 1), $s($emptyInterval, $i(1, 3), $i(1, 4)));
Assert::equal($set->filterByNightsCount('<=', 1), $s($emptyInterval, $i(1, 2)));
Assert::equal($set->filterByNightsCount('<', 1), $s($emptyInterval));
