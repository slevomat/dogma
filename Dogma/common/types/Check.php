<?php
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma;

use Nette\Utils\Strings;

/**
 * Type and range validations
 */
final class Check
{
    use StaticClassMixin;

    // min length
    const NOT_EMPTY = 1;

    // strict type checks
    const STRICT = true;

    /**
     * @param &mixed $value
     * @param string|string[] $type
     * @param integer|float $min
     * @param integer|float $max
     * @throws \Dogma\InvalidTypeException
     * @throws \Dogma\ValueOutOfRangeException
     */
    public static function type(&$value, $type, $min = null, $max = null)
    {
        if (is_array($type)) {
            list($type, $itemTypes) = $type;
        }
        switch ($type) {
            case Type::NULL:
                if (!is_null($value)) {
                    throw new \Dogma\InvalidTypeException($type, $value);
                }
                break;
            case Type::BOOLEAN:
                if ($min !== null) {
                    throw new \InvalidArgumentException(sprintf('Parameter $min is not aplicable with type %s.', $type));
                } elseif ($max !== null) {
                    throw new \InvalidArgumentException(sprintf('Parameter $max is not aplicable with type %s.', $type));
                }
                self::boolean($value);
                break;
            case Type::INTEGER:
                self::integer($value, $min, $max);
                break;
            case Type::FLOAT:
                self::float($value, $min, $max);
                break;
            case Type::STRING:
                self::string($value, $min, $max);
                break;
            case Type::PHP_ARRAY:
                self::phpArray($value, $min, $max);
                break;
            case Type::OBJECT:
                if ($min !== null) {
                    throw new \InvalidArgumentException(sprintf('Parameter $min is not aplicable with type %s.', $type));
                } elseif ($max !== null) {
                    throw new \InvalidArgumentException(sprintf('Parameter $max is not aplicable with type %s.', $type));
                }
                self::object($value);
                break;
            case Type::RESOURCE:
                if ($max !== null) {
                    throw new \InvalidArgumentException(sprintf('Parameter $max is not aplicable with type %s.', $type));
                }
                self::resource($value, $min);
                break;
            case Type::PHP_CALLABLE:
                if ($max !== null) {
                    throw new \InvalidArgumentException(sprintf('Parameter $max is not aplicable with type %s.', $type));
                }
                self::phpCallable($value);
                break;
            default:
                if ($min !== null) {
                    throw new \InvalidArgumentException(sprintf('Parameter $min is not aplicable with type %s.', $type));
                } elseif ($max !== null) {
                    throw new \InvalidArgumentException(sprintf('Parameter $max is not aplicable with type %s.', $type));
                }
                self::object($value, $type);
                break;
        }
        if (isset($itemTypes)) {
            self::itemsOfTypes($value, $itemTypes);
        }
    }

    /**
     * @param &mixed $value
     * @param string $type
     * @param integer|float $min
     * @param integer|float $max
     * @throws \Dogma\InvalidTypeException
     * @throws \Dogma\ValueOutOfRangeException
     */
    public static function nullableType(&$value, $type, $min = null, $max = null)
    {
        if ($value === null) {
            return;
        }
        self::type($value, $type, $min, $max);
    }

    /**
     * @param &mixed $value
     * @param string[] $types
     * @param integer|null $min
     * @param integer|null $max
     * @throws \Dogma\InvalidTypeException
     */
    public static function types(&$value, array $types, $min = null, $max = null)
    {
        foreach ($types as $type) {
            if ($type === Type::NULL && $value === null) {
                return;
            }
            try {
                self::type($value, $type, $min, $max);
                return;
            } catch (\Dogma\InvalidTypeException $e) {
                // pass
            }
        }
        throw new \Dogma\InvalidTypeException($types, $value);
    }

    /**
     * @param &array|\Traversable $array
     * @param string $types
     * @param integer|null $valueMin
     * @param integer|null $valueMax
     * @throws \Dogma\InvalidTypeException
     */
    public static function itemsOfType($array, $type, $valueMin = null, $valueMax = null)
    {
        foreach ($array as &$value) {
            self::type($value, $type, $valueMin, $valueMax);
        }
    }

    /**
     * @param &array|\Traversable $array
     * @param string[] $types
     * @param integer|null $valueMin
     * @param integer|null $valueMax
     * @throws \Dogma\InvalidTypeException
     */
    public static function itemsOfTypes($array, array $types, $valueMin = null, $valueMax = null)
    {
        foreach ($array as &$value) {
            self::types($value, $types, $valueMin, $valueMax);
        }
    }

    /**
     * @param &mixed $value
     * @throws \Dogma\InvalidTypeException
     */
    public static function boolean(&$value)
    {
        if ($value === true || $value === false) {
            return;
        }
        if ($value === 0 || $value === 1 || $value === 0.0 || $value === 1.0 || $value === ''
            || $value === '0' || $value === '1' || $value === '0.0' || $value === '1.0'
        ) {
            $value = (bool) $value;
            return;
        }
        throw new \Dogma\InvalidTypeException(Type::BOOLEAN, $value);
    }

    /**
     * @param &mixed $value
     * @throws \Dogma\InvalidTypeException
     */
    public static function nullableBoolean(&$value)
    {
        if ($value === null) {
            return;
        }
        self::boolean($value);
    }

    /**
     * @param &mixed $value
     * @param integer $min
     * @param integer $max
     * @throws \Dogma\InvalidTypeException
     * @throws \Dogma\ValueOutOfRangeException
     */
    public static function integer(&$value, $min = null, $max = null)
    {
        if (is_integer($value)) {
            if ($min !== null || $max !== null) {
                self::range($value, $min, $max);
            }
            return;
        }
        if (!is_numeric($value)) {
            throw new \Dogma\InvalidTypeException(Type::INTEGER, $value);
        }
        $actualType = gettype($value);
        $converted = (int) $value;
        $copy = $converted;
        settype($copy, $actualType);
        if ($copy !== $value && (!is_string($value) || rtrim(rtrim($value, '0'), '.') !== $copy)) {
            throw new \Dogma\InvalidTypeException(Type::INTEGER, $value);
        }
        if ($min !== null || $max !== null) {
            self::range($value, $min, $max);
        }
        $value = $converted;
    }

    /**
     * @param &mixed $value
     * @param integer $min
     * @param integer $max
     * @throws \Dogma\InvalidTypeException
     * @throws \Dogma\ValueOutOfRangeException
     */
    public static function nullableInteger(&$value, $min = null, $max = null)
    {
        if ($value === null) {
            return;
        }
        self::integer($value, $min, $max);
    }

    /**
     * Positive integer (higher then 0)
     * @param &mixed $value
     * @param integer $max
     * @throws \Dogma\InvalidTypeException
     * @throws \Dogma\ValueOutOfRangeException
     */
    public static function natural(&$value, $max = null)
    {
        self::integer($value, 1, $max);
    }

    /**
     * Positive integer (higher then 0) or null
     * @param &mixed $value
     * @param integer $max
     * @throws \Dogma\InvalidTypeException
     * @throws \Dogma\ValueOutOfRangeException
     */
    public static function nullableNatural(&$value, $max = null)
    {
        self::nullableInteger($value, 1, $max);
    }

    /**
     * @param &mixed $value
     * @param integer $min
     * @param integer $max
     * @throws \Dogma\InvalidTypeException
     * @throws \Dogma\InvalidValueException
     * @throws \Dogma\ValueOutOfRangeException
     */
    public static function float(&$value, $min = null, $max = null)
    {
        if (is_float($value)) {
            if (is_nan($value)) {
                throw new \Dogma\InvalidValueException($value, 'valid float');
            }
            if ($value === INF || $value === -INF) {
                throw new \Dogma\ValueOutOfRangeException($value, -INF, INF);
            }
            if ($min !== null || $max !== null) {
                self::range($value, $min, $max);
            }
            return;
        }
        if (!is_numeric($value)) {
            throw new \Dogma\InvalidTypeException(Type::FLOAT, $value);
        }
        $actualType = gettype($value);
        $converted = (float) $value;
        if ($converted === INF || $converted === -INF) {
            throw new \Dogma\ValueOutOfRangeException($value, -INF, INF);
        }
        $copy = $converted;
        settype($copy, $actualType);
        if ($copy !== $value && (!is_string($value) || rtrim(rtrim($value, '0'), '.') !== $copy)) {
            throw new \Dogma\InvalidTypeException(Type::FLOAT, $value);
        }
        if ($min !== null || $max !== null) {
            self::range($value, $min, $max);
        }
        $value = $converted;
    }

    /**
     * @param &mixed $value
     * @param float|integer $min
     * @param float|integer $max
     * @throws \Dogma\InvalidTypeException
     * @throws \Dogma\InvalidValueException
     * @throws \Dogma\ValueOutOfRangeException
     */
    public static function nullableFloat(&$value, $min = null, $max = null)
    {
        if ($value === null) {
            return;
        }
        self::float($value, $min, $max);
    }

    /**
     * @param &mixed $value
     * @param integer $minLength
     * @param integer $maxLength
     * @throws \Dogma\InvalidTypeException
     * @throws \Dogma\ValueOutOfRangeException
     */
    public static function string(&$value, $minLength = null, $maxLength = null)
    {
        if (is_string($value)) {
            if ($minLength !== null || $maxLength !== null) {
                self::length($value, $minLength, $maxLength);
            }
            return;
        }
        if (!is_numeric($value)) {
            throw new \Dogma\InvalidTypeException(Type::STRING, $value);
        }
        $actualType = gettype($value);
        $converted = (string) $value;
        $copy = $converted;
        settype($copy, $actualType);
        if ($copy !== $value) {
            throw new \Dogma\InvalidTypeException(Type::FLOAT, $value);
        }
        if ($minLength !== null || $maxLength !== null) {
            self::length($value, $minLength, $maxLength);
        }
        $value = $converted;
    }

    /**
     * @param &mixed $value
     * @param integer $minLength
     * @param integer $maxLength
     * @throws \Dogma\InvalidTypeException
     * @throws \Dogma\ValueOutOfRangeException
     */
    public static function nullableString(&$value, $minLength = null, $maxLength = null)
    {
        if ($value === null) {
            return;
        }
        self::string($value, $minLength, $maxLength);
    }

    /**
     * @param mixed $value
     * @throws \Dogma\InvalidTypeException
     */
    public static function traversable($value)
    {
        if (!self::isTraversable($value)) {
            throw new \Dogma\InvalidTypeException('array|Traversable', $value);
        }
    }

    /**
     * @param mixed $value
     * @param integer $minLength
     * @param integer $maxLength
     * @throws \Dogma\InvalidTypeException
     */
    public static function phpArray($value, $minLength = null, $maxLength = null)
    {
        if (!is_array($value)) {
            throw new \Dogma\InvalidTypeException(Type::PHP_ARRAY, $value);
        }
        self::range(count($value), $minLength, $maxLength);
    }

    /**
     * @param mixed $array
     * @param integer $minLength
     * @param integer $maxLength
     * @throws \Dogma\InvalidTypeException
     */
    public static function plainArray($value, $minLength = null, $maxLength = null)
    {
        self::phpArray($value, $minLength, $maxLength);
        if (!self::isPlainArray($value)) {
            throw new \Dogma\InvalidTypeException('array with integer keys from 0', $value);
        }
    }

    /**
     * @param mixed $value
     * @param string|null $className
     * @throws \Dogma\InvalidTypeException
     */
    public static function object($value, $className = null)
    {
        if (!is_object($value)) {
            throw new \Dogma\InvalidTypeException(Type::OBJECT, $value);
        }
        if ($className !== null && !is_a($value, $className)) {
            throw new \Dogma\InvalidTypeException($className, $value);
        }
    }

    /**
     * @param mixed $value
     * @param string|null $className
     * @throws \Dogma\InvalidTypeException
     */
    public static function nullableObject($value, $className = null)
    {
        if ($value === null) {
            return;
        }
        self::object($value, $className);
    }

    /**
     * @param mixed $value
     * @param string $type
     * @throws \Dogma\InvalidTypeException
     */
    public static function resource($value, $type = null)
    {
        if (!is_resource($value)) {
            throw new \Dogma\InvalidTypeException(Type::RESOURCE, $value);
        }
        if ($type !== null && get_resource_type($value) !== $type) {
            throw new \Dogma\InvalidTypeException(sprintf('%s (%s)', Type::RESOURCE, $type), $value);
        }
    }

    /**
     * @param mixed $value
     * @throws \Dogma\InvalidTypeException
     */
    public static function phpCallable($value)
    {
        if (!is_callable($value)) {
            throw new \Dogma\InvalidTypeException('callable', $value);
        }
    }

    /**
     * @param mixed $value
     * @param string $parentClass
     * @throws \Dogma\InvalidValueException
     */
    public static function className($value, $parentClass = null)
    {
        self::string($value);
        if (!class_exists($value, true)) {
            throw new \Dogma\InvalidValueException($value, 'class name');
        }
        if ($parentClass !== null && !is_subclass_of($value, $parentClass)) {
            throw new \Dogma\InvalidTypeException(sprintf('child class of %s', $parentClass), $value);
        }
    }

    /**
     * @param mixed $value
     * @throws \Dogma\InvalidValueException
     */
    public static function typeName($value)
    {
        self::string($value);
        if (!class_exists($value, true) && !in_array($value, Type::listTypes())) {
            throw new \Dogma\InvalidValueException($value, 'type name');
        }
    }

    /**
     * @param $value
     * @param integer|null $min
     * @param integer|null $max
     * @throws \Dogma\ValueOutOfRangeException
     */
    public static function length($value, $min = null, $max = null)
    {
        if (!is_string($value)) {
            throw new \Dogma\InvalidTypeException(Type::STRING, $value);
        }
        $length = Strings::length($value);
        self::range($length, $min, $max);
    }

    /**
     * @param mixed $value
     * @param integer|float $min
     * @param integer|float $max
     * @throws \Dogma\ValueOutOfRangeException
     */
    public static function range($value, $min = null, $max = null)
    {
        if ($min !== null && $value < $min) {
            throw new \Dogma\ValueOutOfRangeException($value, $min, $max);
        }
        if ($max !== null && $value > $max) {
            throw new \Dogma\ValueOutOfRangeException($value, $min, $max);
        }
    }

    /**
     * @param mixed ...$values
     * @throws \Dogma\ValueOutOfRangeException
     */
    public static function oneOf(...$values)
    {
        $count = 0;
        foreach ($values as $value) {
            if (isset($value)) {
                $count++;
            }
        }
        if ($count !== 1) {
            throw new \Dogma\ValueOutOfRangeException($count, 1, 1);
        }
    }

    /**
     * @param mixed $value
     * @return boolean
     */
    public static function isTraversable($value)
    {
        return is_array($value) || $value instanceof \StdClass
        || ($value instanceof \Traversable && !$value instanceof NonIterable);
    }

    /**
     * @param mixed $value
     * @return boolean
     */
    public static function isPlainArray($value)
    {
        return is_array($value) && (($count = count($value)) === 0 || array_keys($value) === range(0, $count - 1));
    }

}