<?php declare(strict_types = 1);

namespace Dogma\Tests\Language\Locale;

use Dogma\Country\Country;
use Dogma\Language\Collator;
use Dogma\Language\Language;
use Dogma\Language\Locale\Locale;
use Dogma\Language\Locale\LocaleCalendar;
use Dogma\Language\Locale\LocaleColBackwards;
use Dogma\Language\Locale\LocaleColCaseFirst;
use Dogma\Language\Locale\LocaleCollation;
use Dogma\Language\Locale\LocaleKeyword;
use Dogma\Language\Locale\LocaleNumbers;
use Dogma\Language\Script;
use Dogma\Money\Currency;
use Dogma\Tester\Assert;
use Tester\Environment;

require_once __DIR__ . '/../../bootstrap.php';

if (PHP_VERSION_ID > 70011) {
    // broken Locale::canonicalize and Locale::parseLocale
    Environment::skip();
    exit;
}

$localeString = 'cs_Latn_CZ_VAR1_VAR2_X_PRI1_PRI2@currency=CZK;numbers=arab;calendar=iso8601;collation=phonebook;colbackwards=yes;colcasefirst=lower';
$localeStringCanonicalized = 'cs_Latn_CZ_VAR1_VAR2_X_PRI1_PRI2@calendar=iso8601;colbackwards=yes;colcasefirst=lower;collation=phonebook;currency=CZK;numbers=arab';


get:
$locale = Locale::get($localeString);
$simple = Locale::get('cs');


create:
$created = Locale::create(
    Language::from(Language::Czech->value),
    Country::from(Country::Czechia->value),
    Script::from(Script::Latin->value),
    ['VAR1', 'VAR2'],
    ['PRI1', 'PRI2'],
    [
        LocaleKeyword::CALENDAR => LocaleCalendar::Iso8601->value,
        LocaleKeyword::COL_BACKWARDS => LocaleColBackwards::Yes->value,
        LocaleKeyword::COL_CASE_FIRST => LocaleColCaseFirst::Lower->value,
        LocaleKeyword::COLLATION => LocaleCollation::Phonebook->value,
        LocaleKeyword::CURRENCY => Currency::CzechKoruna->value,
        LocaleKeyword::NUMBERS => LocaleNumbers::ArabicIndic->value,
    ]
);
Assert::same($created, $locale);


removeCollation:
$safeLocale = $locale->removeCollation();
Assert::type($safeLocale, Locale::class);
Assert::same($safeLocale->getValue(), 'cs_Latn_CZ_VAR1_VAR2_X_PRI1_PRI2@calendar=iso8601;currency=CZK;numbers=arab');


getDefault:
Assert::type(Locale::getDefault(), Locale::class);


getCollator:
$collator = $locale->getCollator();
Assert::type($collator, Collator::class);
Assert::same($collator->getLocaleObject()->getValue(), 'cs');


matches:
Assert::true($locale->matches($simple));


findBestMatch:
Assert::same($locale->findBestMatch(['cs', 'cs_Latn_CZ', 'cs_CZ', 'en'])->getValue(), 'cs_Latn_CZ');


getValue:
Assert::same($locale->getValue(), $localeStringCanonicalized);
Assert::same($simple->getValue(), 'cs');


getLanguage:
Assert::same($locale->getLanguage(), Language::from(Language::Czech->value));
Assert::same($simple->getLanguage(), Language::from(Language::Czech->value));


getScript:
Assert::same($locale->getScript(), Script::from(Script::Latin->value));
Assert::null($simple->getScript());


getCountry:
Assert::same($locale->getCountry(), Country::from(Country::Czechia->value));
Assert::null($simple->getCountry());


getVariants:
Assert::same($locale->getVariants(), ['VAR1', 'VAR2']);
Assert::same($simple->getVariants(), []);


getVariant:
Assert::same($locale->getVariant(0), 'VAR1');
Assert::same($locale->getVariant(1), 'VAR2');
Assert::null($simple->getVariant(0));


hasVariant:
Assert::true($locale->hasVariant('VAR1'));
Assert::true($locale->hasVariant('VAR2'));
Assert::false($locale->hasVariant('VAR3'));


getPrivates:
Assert::same($locale->getPrivates(), ['PRI1', 'PRI2']);
Assert::same($simple->getPrivates(), []);


getPrivate:
Assert::same($locale->getPrivate(0), 'PRI1');
Assert::same($locale->getPrivate(1), 'PRI2');
Assert::null($simple->getPrivate(0));


getKeywords:
Assert::same($locale->getKeywords(), [
    LocaleKeyword::CALENDAR => LocaleCalendar::Iso8601->value,
    LocaleKeyword::COL_BACKWARDS => LocaleColBackwards::Yes->value,
    LocaleKeyword::COL_CASE_FIRST => LocaleColCaseFirst::Lower->value,
    LocaleKeyword::COLLATION => LocaleCollation::Phonebook->value,
    LocaleKeyword::CURRENCY => Currency::CzechKoruna->value,
    LocaleKeyword::NUMBERS => LocaleNumbers::ArabicIndic->value,
]);
Assert::same($simple->getKeywords(), []);


getKeyword:
Assert::same($locale->getKeyword(LocaleKeyword::CURRENCY), Currency::CzechKoruna->value);
Assert::same($locale->getKeyword(LocaleKeyword::NUMBERS), LocaleNumbers::ArabicIndic->value);
Assert::same($locale->getKeyword(LocaleKeyword::CALENDAR), LocaleCalendar::Iso8601->value);
Assert::same($locale->getKeyword(LocaleKeyword::COLLATION), LocaleCollation::Phonebook->value);
Assert::same($locale->getKeyword(LocaleKeyword::COL_BACKWARDS), LocaleColBackwards::Yes->value);
Assert::same($locale->getKeyword(LocaleKeyword::COL_CASE_FIRST), LocaleColCaseFirst::Lower->value);
Assert::null($locale->getKeyword('foo'));


getCurrency:
Assert::same($locale->getCurrency(), Currency::from(Currency::CzechKoruna->value));
Assert::null($simple->getCurrency());


getNumbers:
Assert::same($locale->getNumbers(), LocaleNumbers::from(LocaleNumbers::ArabicIndic->value));
Assert::null($simple->getNumbers());


getCalendar:
Assert::same($locale->getCalendar(), LocaleCalendar::from(LocaleCalendar::Iso8601->value));
Assert::null($simple->getCalendar());


getCollation:
Assert::same($locale->getCollation(), LocaleCollation::from(LocaleCollation::Phonebook->value));
Assert::null($simple->getCollation());


getCollationOptions:
Assert::same($locale->getCollationOptions(), [
    LocaleKeyword::COL_BACKWARDS => LocaleColBackwards::from(LocaleColBackwards::Yes->value),
    LocaleKeyword::COL_CASE_FIRST => LocaleColCaseFirst::from(LocaleColCaseFirst::Lower->value),
]);
Assert::same($simple->getCollationOptions(), []);
