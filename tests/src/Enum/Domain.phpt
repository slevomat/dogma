<?php declare(strict_types = 1);

namespace Dogma\Tests\Enum;

use Dogma\Country\Country;
use Dogma\Http\HttpHeader;
use Dogma\InvalidValueException;
use Dogma\Io\ContentType\ContentType;
use Dogma\Language\Language;
use Dogma\Language\Locale\LocaleKeyword;
use Dogma\Language\Locale\LocaleVariant;
use Dogma\Money\Currency;
use Dogma\Tester\Assert;
use Dogma\Time\DateTimeUnit;
use Dogma\Time\DayOfWeek;
use Dogma\Time\DaysOfWeek;
use Dogma\Time\Month;
use Dogma\Time\TimeZone;

require_once __DIR__ . '/../bootstrap.php';


country:
$country = Country::parse('cz');
Assert::same($country->value, 'CZ');
Assert::same($country->getName(), 'Czechia');
Assert::same($country->getLongCode(), 'CZE');
Assert::same($country->getIdent(), 'czechia');
Assert::same(Country::getByLongCode('CZE')->value, 'CZ');
Assert::same(Country::getByIdent('czechia')->value, 'CZ');


currency:
$currency = Currency::parse('eur');
Assert::same($currency->value, 'EUR');
Assert::same($currency->getName(), 'Euro');
Assert::same($currency->getIdent(), 'euro');
Assert::same($currency->getByIdent('euro')->value, 'EUR');


language:
$language = Language::parse('CS');
Assert::same($language->value, 'cs');
Assert::same($language->getName(), 'czech');
Assert::same($language->getNativeName(), 'čeština');
Assert::same($language->getIdent(), 'czech');
Assert::same(Language::getByIdent('czech')->value, 'cs');


dayOfWeek:
$monday = DayOfWeek::getByName('MONDAY');
Assert::same($monday->value, 1);
Assert::same($monday->getName(), 'monday');
Assert::same($monday->getShortcut(), 'mon');
Assert::false($monday->isWeekend());
Assert::true(DayOfWeek::Saturday->isWeekend());
Assert::true(DayOfWeek::Sunday->isWeekend());


month:
$february = Month::getByName('FEBRUARY');
Assert::same($february->value, 2);
Assert::same($february->getName(), 'february');
Assert::same($february->getDaysForYear(2000), 29);
Assert::same($february->getDaysForYear(1900), 28);
Assert::same(Month::April->getDaysForYear(2024), 30);


dateTimeUnit:
$minute = DateTimeUnit::Minute;
Assert::same($minute->value, 'minute');
Assert::true($minute->isTime());
Assert::false($minute->isDate());
Assert::same($minute->getComparisonFormat(), 'YmdHi');
Assert::true(DateTimeUnit::Day->isDate());
Assert::false(DateTimeUnit::Day->isTime());


daysOfWeek:
$workDays = DaysOfWeek::createFromDayOfWeekList([
    DayOfWeek::Monday,
    DayOfWeek::Tuesday,
    DayOfWeek::Wednesday,
    DayOfWeek::Thursday,
    DayOfWeek::Friday,
]);
$weekend = DaysOfWeek::weekend();
Assert::same($workDays->value, 31);
Assert::same($weekend->value, 96);
Assert::same(array_map(static function (DayOfWeek $day): int {
    return $day->value;
}, $weekend->toArray()), [6, 7]);
Assert::same(DaysOfWeek::createWithAllDays()->value, 127);
Assert::same(DaysOfWeek::empty()->value, 0);
Assert::same($weekend->count(), 2);
Assert::true($workDays->containsDay(DayOfWeek::Monday));
Assert::false($workDays->containsDay(DayOfWeek::Sunday));
Assert::true($workDays->contains(DaysOfWeek::createFromDays(DayOfWeek::Monday, DayOfWeek::Friday)));
Assert::true($workDays->containsAll(DayOfWeek::Monday, DayOfWeek::Friday));
Assert::true($weekend->containsAny(DayOfWeek::Saturday, DayOfWeek::Monday));
Assert::same($workDays->union($weekend)->value, 127);
Assert::same($workDays->intersect($weekend)->value, 0);
Assert::same($workDays->subtract(DaysOfWeek::createFromDays(DayOfWeek::Tuesday))->value, 29);
Assert::same($workDays->add(DayOfWeek::Saturday)->value, 63);
Assert::same($weekend->remove(DayOfWeek::Saturday)->value, 64);
Assert::same($workDays->difference($weekend)->value, 127);
Assert::same($workDays->invert()->value, 96);


partialValues:
$contentType = ContentType::from('application/json');
Assert::same($contentType->value, 'application/json');
Assert::same($contentType->getBaseType()->value, 'application');
Assert::same($contentType->getExtension(), 'json');
Assert::true($contentType->isJson());
Assert::exception(static function (): void {
    ContentType::from('invalid');
}, InvalidValueException::class);

$header = HttpHeader::from('x-request-id');
Assert::same($header->value, 'X-Request-ID');
Assert::exception(static function (): void {
    HttpHeader::from('1');
}, InvalidValueException::class);

$keyword = LocaleKeyword::from('CURRENCY');
Assert::same($keyword->value, 'currency');
$variant = LocaleVariant::from('TRADITIONAL');
Assert::same($variant->value, 'TRADITIONAL');
Assert::exception(static function (): void {
    LocaleVariant::from('invalid-variant');
}, InvalidValueException::class);

$timeZone = TimeZone::from(TimeZone::EUROPE_PRAGUE);
Assert::same($timeZone->value, 'Europe/Prague');
Assert::same($timeZone->getDateTimeZone()->getName(), 'Europe/Prague');
Assert::false($timeZone->isDeprecated());
Assert::true(TimeZone::from('US/Eastern')->isDeprecated());
Assert::exception(static function (): void {
    TimeZone::from('Not/A-Timezone');
}, InvalidValueException::class);
