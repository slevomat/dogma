<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md'; distributed with this source code
 */

// spell-check-ignore: colalternate colbackwards colcasefirst colhiraganaquaternary colnormalization colnumeric colstrength

namespace Dogma\Language\Locale;

use Dogma\InvalidRegularExpressionException;
use Dogma\InvalidValueException;
use function preg_match;
use function strtolower;

final readonly class LocaleKeyword
{

    public string $value;

    public function __construct(string $value)
    {
        if (!self::validateValue($value)) {
            throw new InvalidValueException($value, self::class);
        }

        $this->value = $value;
    }

    public static function from(string $value): self
    {
        return new self($value);
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public const CALENDAR = 'calendar';
    public const COLLATION = 'collation';
    public const CURRENCY = 'currency';
    public const NUMBERS = 'numbers';

    public const COL_ALTERNATE = 'colalternate';
    public const COL_BACKWARDS = 'colbackwards';
    public const COL_CASE_FIRST = 'colcasefirst';
    public const COL_HIRAGANA_QUATERNARY = 'colhiraganaquaternary';
    public const COL_NORMALIZATION = 'colnormalization';
    public const COL_NUMERIC = 'colnumeric';
    public const COL_STRENGTH = 'colstrength';

    /**
     * @return string[]
     */
    public static function getCollationOptions(): array
    {
        return [
            self::COL_ALTERNATE => LocaleColAlternate::class,
            self::COL_BACKWARDS => LocaleColBackwards::class,
            self::COL_CASE_FIRST => LocaleColCaseFirst::class,
            self::COL_HIRAGANA_QUATERNARY => LocaleColHiraganaQuaternary::class,
            self::COL_NORMALIZATION => LocaleColNormalization::class,
            self::COL_NUMERIC => LocaleColNumeric::class,
            self::COL_STRENGTH => LocaleColStrength::class,
        ];
    }

    public static function validateValue(string &$value): bool
    {
        $value = strtolower($value);

        $regexp = '/^' . self::getValueRegexp() . '?$/';
        $result = preg_match($regexp, $value);
        if ($result === false) {
            throw new InvalidRegularExpressionException($regexp);
        }

        return (bool) $result;
    }

    public static function getValueRegexp(): string
    {
        return '[a-z]+';
    }

}
