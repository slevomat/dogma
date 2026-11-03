<?php declare(strict_types = 1);

namespace Dogma\Tests\PHPStan;

use Dogma\Time\Interval\DateInterval;
use Dogma\Time\Interval\DateIntervalSet;
use Dogma\Time\Interval\NightIntervalSet;
use Dogma\Time\IntervalData\DateIntervalData;
use Dogma\Time\IntervalData\DateIntervalDataSet;
use Dogma\Time\IntervalData\NightIntervalData;
use Dogma\Time\IntervalData\NightIntervalDataSet;
use function PHPStan\Testing\assertType;
use function strlen;

$dateData = DateIntervalData::createFromDateInterval(DateInterval::all(), 'source');
assertType('Dogma\Time\IntervalData\DateIntervalData<string>', $dateData);
assertType('string', $dateData->getData());
assertType('list<array{Dogma\Time\Date, string}>', $dateData->toDateDataArray());

$dateSetFromIntervals = DateIntervalDataSet::createFromDateIntervalSet(DateIntervalSet::all(), 'source');
assertType('Dogma\Time\IntervalData\DateIntervalDataSet<string>', $dateSetFromIntervals);

$dateSet = new DateIntervalDataSet([$dateData]);
assertType('list<Dogma\Time\IntervalData\DateIntervalData<string>>', $dateSet->getIntervals());
assertType(
    'Traversable<int, Dogma\Time\IntervalData\DateIntervalData<string>>',
    $dateSet->getIterator()
);

$mappedData = $dateSet->collectData(static fn (string $data, DateInterval $interval): int => strlen($data));
assertType('Dogma\Time\IntervalData\DateIntervalDataSet<int<0, max>>', $mappedData);

$mappedIntervals = $dateSet->map(
    /**
     * @param DateIntervalData<string> $interval
     * @return DateIntervalData<int>
     */
    static function (DateIntervalData $interval): DateIntervalData {
        return DateIntervalData::createFromDateInterval($interval->toDateInterval(), 1);
    }
);
assertType('list<Dogma\Time\IntervalData\DateIntervalData<int>>', $mappedIntervals);

$nightSetFromIntervals = NightIntervalDataSet::createFromNightIntervalSet(NightIntervalSet::all(), 'source');
assertType('Dogma\Time\IntervalData\NightIntervalDataSet<string>', $nightSetFromIntervals);

$nightSet = $dateSet->toNightIntervalDataSet();
assertType('list<Dogma\Time\IntervalData\NightIntervalData<string>>', $nightSet->getIntervals());
assertType(
    'Dogma\Time\IntervalData\NightIntervalDataSet<int<0, max>>',
    $nightSet->collectData(static fn (string $data): int => strlen($data))
);

$nightData = NightIntervalData::createFromDateIntervalData($dateData);
assertType(
    'Dogma\Time\IntervalData\NightIntervalData<null>|Dogma\Time\IntervalData\NightIntervalData<string>',
    $nightData
);
assertType(
    'Dogma\Time\IntervalData\DateIntervalData<null>|Dogma\Time\IntervalData\DateIntervalData<string>',
    $nightData->toDateIntervalData()
);
