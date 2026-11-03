<?php declare(strict_types = 1);

namespace Dogma\Tests\Enum;

use Dogma\Country\Country;
use Dogma\Http\HttpHeader;
use Dogma\InvalidValueException;
use Dogma\Io\ContentType\ContentType;
use Dogma\Language\Language;
use Dogma\Money\Currency;
use Dogma\Tester\Assert;
use Dogma\Time\DateTimeUnit;
use Dogma\Time\DayOfWeek;
use Dogma\Time\DaysOfWeek;
use Dogma\Time\Month;
use Dogma\Time\TimeZone;

require_once __DIR__ . '/../bootstrap.php';


country:
$country = Country::get('cz');
Assert::same($country->getValue(), 'CZ');
Assert::same($country->getName(), 'Czechia');
Assert::same($country->getLongCode(), 'CZE');
Assert::same($country->getIdent(), 'czechia');
Assert::same(Country::getByLongCode('CZE')->getValue(), 'CZ');
Assert::same(Country::getByIdent('czechia')->getValue(), 'CZ');


currency:
$currency = Currency::get('eur');
Assert::same($currency->getValue(), 'EUR');
Assert::same($currency->getName(), 'Euro');
Assert::same($currency->getIdent(), 'euro');
Assert::same($currency->getByIdent('euro')->getValue(), 'EUR');


language:
$language = Language::get('CS');
Assert::same($language->getValue(), 'cs');
Assert::same($language->getName(), 'czech');
Assert::same($language->getNativeName(), 'čeština');
Assert::same($language->getIdent(), 'czech');
Assert::same(Language::getByIdent('czech')->getValue(), 'cs');


dayOfWeek:
$monday = DayOfWeek::getByName('MONDAY');
Assert::same($monday->getValue(), 1);
Assert::same($monday->getName(), 'monday');
Assert::same($monday->getShortcut(), 'mon');
Assert::false($monday->isWeekend());
Assert::true(DayOfWeek::saturday()->isWeekend());
Assert::true(DayOfWeek::sunday()->isWeekend());


month:
$february = Month::getByName('FEBRUARY');
Assert::same($february->getValue(), 2);
Assert::same($february->getName(), 'february');
Assert::same($february->getDaysForYear(2000), 29);
Assert::same($february->getDaysForYear(1900), 28);
Assert::same(Month::april()->getDaysForYear(2024), 30);


dateTimeUnit:
$minute = DateTimeUnit::minute();
Assert::same($minute->getValue(), 'minute');
Assert::true($minute->isTime());
Assert::false($minute->isDate());
Assert::same($minute->getComparisonFormat(), 'YmdHi');
Assert::true(DateTimeUnit::day()->isDate());
Assert::false(DateTimeUnit::day()->isTime());


daysOfWeek:
$workDays = DaysOfWeek::get(
    DaysOfWeek::MONDAY,
    DaysOfWeek::TUESDAY,
    DaysOfWeek::WEDNESDAY,
    DaysOfWeek::THURSDAY,
    DaysOfWeek::FRIDAY
);
$weekend = DaysOfWeek::get(DaysOfWeek::SATURDAY, DaysOfWeek::SUNDAY);
Assert::same($workDays->getValue(), 31);
Assert::same($weekend->getValue(), 96);
Assert::same(array_map(static fn (DayOfWeek $day): int => $day->getValue(), $weekend->toDays()), [6, 7]);
Assert::true($workDays->containsDay(DayOfWeek::monday()));
Assert::false($workDays->containsDay(DayOfWeek::sunday()));
Assert::same($workDays->union($weekend)->getValue(), 127);
Assert::same($workDays->intersect($weekend)->getValue(), 0);
Assert::same($workDays->subtract(DaysOfWeek::get(DaysOfWeek::TUESDAY))->getValue(), 29);


partialValues:
$contentType = ContentType::get('application/json');
Assert::same($contentType->getValue(), 'application/json');
Assert::same($contentType->getBaseType()->getValue(), 'application');
Assert::same($contentType->getExtension(), 'json');
Assert::true($contentType->isJson());
Assert::exception(static function (): void {
    ContentType::get('invalid');
}, InvalidValueException::class);

$header = HttpHeader::get('x-request-id');
Assert::same($header->getValue(), 'X-Request-ID');
Assert::exception(static function (): void {
    HttpHeader::get('1');
}, InvalidValueException::class);

$timeZone = TimeZone::get(TimeZone::EUROPE_PRAGUE);
Assert::same($timeZone->getDateTimeZone()->getName(), 'Europe/Prague');
Assert::false($timeZone->isDeprecated());
Assert::true(TimeZone::get('US/Eastern')->isDeprecated());
Assert::exception(static function (): void {
    TimeZone::get('Not/A-Timezone');
}, InvalidValueException::class);
