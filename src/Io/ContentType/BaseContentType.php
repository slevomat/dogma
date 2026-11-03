<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Io\ContentType;

use Dogma\InvalidRegularExpressionException;
use Dogma\InvalidValueException;
use function preg_match;

final readonly class BaseContentType
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

    public const string APPLICATION = 'application';
    public const string AUDIO = 'audio';
    public const string FONT = 'font';
    public const string CHEMICAL = 'chemical';
    public const string IMAGE = 'image';
    public const string MESSAGE = 'message';
    public const string MODEL = 'model';
    public const string MULTIPART = 'multipart';
    public const string TEXT = 'text';
    public const string VIDEO = 'video';

    public static function getValueRegexp(): string
    {
        return '[a-z_]+';
    }

    public static function validateValue(string &$value): bool
    {
        $regexp = '/^' . self::getValueRegexp() . '?$/';
        $result = preg_match($regexp, $value);
        if ($result === false) {
            throw new InvalidRegularExpressionException($regexp);
        }

        return (bool) $result;
    }

}
