<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Application;

use Dogma\Application\Colors as C;
use Dogma\Check;
use Dogma\InvalidArgumentException;
use Dogma\ShouldNotHappenException;
use Dogma\StrictBehaviorMixin;
use Nette\Neon\Neon;
use stdClass;
use function array_key_exists;
use function array_keys;
use function array_map;
use function array_merge;
use function array_pad;
use function error_get_last;
use function explode;
use function file_get_contents;
use function getopt;
use function implode;
use function is_array;
use function is_bool;
use function is_file;
use function is_numeric;
use function is_string;
use function parse_ini_file;
use function sprintf;
use function str_ends_with;
use function strval;
use function trigger_error;

final class Configurator extends stdClass
{
    use StrictBehaviorMixin;

    private const int HELP_COLUMN_WIDTH = 32;

    public const string FLAG = 'flag';
    public const string FLAG_VALUE = 'flag-value';
    public const string VALUE = 'value';
    public const string VALUES = 'values';
    public const string ENUM = 'enum';
    public const string SET = 'set';
    public const string MAP = 'map';

    /** @var array<string, mixed> */
    private array $values = [];

    /** @var array<string, array<array-key, mixed>> */
    private array $profiles = [];

    /**
     * @param string[]|string[][] $arguments
     * @param mixed[] $defaults
     */
    public function __construct(private array $arguments, private array $defaults = [])
    {
    }

    public function hasValues(): bool
    {
        foreach ($this->values as $value) {
            if ($value !== null) {
                return true;
            }
        }
        return false;
    }

    public function renderHelp(): string
    {
        $guide = '';
        foreach ($this->arguments as $name => $config) {
            if (is_string($config)) {
                $guide .= $config . "\n";
                continue;
            }
            $row = '';
            [$short, $type, $info, $hint, $values] = array_pad($config, 5, null);
            $row .= $short ? C::white('  -' . $short) : '    ';
            $row .= C::white(' --' . $name);
            if ($type === self::FLAG_VALUE || $type === self::VALUE || $type === self::VALUES || $type === self::ENUM || $type === self::SET) {
                $row .= C::gray($hint ? " <$hint>" : ' <value>');
            }
            $row = C::padString($row, self::HELP_COLUMN_WIDTH);
            $row .= ' ' . $info;
            if ($type === self::ENUM || $type === self::SET) {
                /** @var string[] $valuesList */
                $valuesList = $values ?? [];
                $row .= '; values: ' . implode('|', array_map(C::lyellow(...), $valuesList));
            }
            if (isset($this->defaults[$name])) {
                if ($type === self::VALUES || $type === self::SET) {
                    $default = $this->defaults[$name];
                    Check::array($default);
                    $row .= '; default: ' . implode(',', array_map(function (mixed $value): string {
                        return C::lyellow($this->format($value));
                    }, $default));
                } else {
                    $row .= '; default: ' . C::lyellow($this->format($this->defaults[$name]));
                }
            }
            $guide .= $row . "\n";
        }

        return $guide . "\n";
    }

    public function loadCliArguments(): void
    {
        $short = [];
        $shortAlt = [];
        $long = [];
        $longAlt = [];
        foreach ($this->arguments as $name => $config) {
            if (is_string($config)) {
                continue;
            }
            [$shortcut, $type] = $config;
            if ($type === self::FLAG_VALUE) {
                if ($shortcut) {
                    $short[] = $shortcut . '';
                    $shortAlt[] = $shortcut . ':';
                }
                $long[] = $name . '';
                $longAlt[] = $name . ':';
            } else {
                if ($shortcut) {
                    $short[] = $shortcut . ($type === self::FLAG ? '' : ':');
                }
                $long[] = $name . ($type === self::FLAG ? '' : ':');
            }
        }

        $values = getopt(implode('', $short), $long);
        if ($values === false) {
            throw new ShouldNotHappenException('Something is wrong! ^_^');
        }
        if ($shortAlt || $longAlt) {
            $altValues = getopt(implode('', $shortAlt), $longAlt);
            if ($altValues === false) {
                throw new ShouldNotHappenException('Something is wrong! ^_^');
            }
            $values = array_merge($values, $altValues);
        }
        foreach ($this->arguments as $name => $argument) {
            if (is_string($argument)) {
                $shortcut = $argument;
                $type = null;
            } else {
                [$shortcut, $type] = $argument;
            }

            $value = $values[$name] ?? $values[$shortcut] ?? null;
            if ($value === false) {
                $value = true;
            }

            $value = $this->normalize($value, $type);
            $values[$name] = $value;
            unset($values[$shortcut]);
        }
        $this->values = $values;
    }

    public function loadConfig(string $filePath): void
    {
        if (is_file($filePath)) {
            if (str_ends_with($filePath, '.neon')) {
                $file = file_get_contents($filePath);
                if ($file === false) {
                    /** @var string[] $error */
                    $error = error_get_last();
                    echo C::white(sprintf("Error while reading configuration file: %s!\n\n", $error['message']), C::RED);
                    exit(1);
                }
                $config = Neon::decode($file);
            } elseif (str_ends_with($filePath, '.ini')) {
                $config = parse_ini_file($filePath);
            } else {
                echo C::white("Error: Only .neon and .ini files are supported!\n\n", C::RED);
                exit(1);
            }
        } elseif ($filePath) {
            echo C::white("Configuration file $filePath not found.\n\n", C::RED);
            exit(1);
        } else {
            $config = [];
        }

        Check::array($config);

        foreach (array_keys($config) as $key) {
            if (is_array($config[$key])) {
                $section = $config[$key];
                $this->expandValues($config, $section);
                $config[$key] = $section;
            }
        }

        $this->loadValues($config, false);

        foreach ($config as $key => $value) {
            if (is_string($key) && $key !== '' && $key[0] === '@') {
                Check::array($value);
                $this->profiles[$key] = $value;
            }
        }

        $uses = $this->values['use'] ?? null;
        if ($uses) {
            if (is_string($uses)) {
                $uses = [$uses];
            }
            Check::array($uses);
            foreach ($uses as $use) {
                if (!is_string($use)) {
                    throw new InvalidArgumentException('Configuration profile names must be strings.');
                }
                if (!isset($config[$use])) {
                    die("Configuration profile $use not found.");
                }
                $profile = $config[$use];
                Check::array($profile);
                $this->loadValues($profile, true);
            }
        }
    }

    /**
     * @param mixed[] $config
     * @param mixed[] $section
     */
    private function expandValues(array $config, array &$section): void
    {
        while (isset($section['include'])) {
            $includes = $section['include'];
            unset($section['include']);
            $includes = is_array($includes) ? $includes : [$includes];
            foreach ($includes as $include) {
                if (!is_string($include)) {
                    throw new InvalidArgumentException('Configuration include names must be strings.');
                }
                if (!isset($config[$include]) || !is_array($config[$include])) {
                    throw new InvalidArgumentException("Configuration include '$include' not found.");
                }
                $section = array_merge($section, $config[$include]);
            }
        }
        foreach (array_keys($section) as $key) {
            if (is_array($section[$key])) {
                $nested = $section[$key];
                $this->expandValues($config, $nested);
                $section[$key] = $nested;
            }
        }
    }

    /**
     * @param mixed[] $config
     */
    private function loadValues(array $config, bool $rewrite): void
    {
        foreach ($this->arguments as $name => $foo) {
            if (isset($config[$name]) && ($rewrite || !isset($this->values[$name]))) {
                $this->values[$name] = $this->normalize($config[$name]);
            }
        }
    }

    private function normalize(mixed $value, ?string $type = null): mixed
	{
		if (($type === self::VALUES || $type === self::SET) && is_string($value)) {
			$value = explode(',', $value);
			foreach ($value as &$item) {
				$item = $this->normalize($item);
			}
		} elseif (is_numeric($value)) {
			$value = (float) $value;
			if ($value === (float) (int) $value) {
				$value = (int) $value;
			}
		}

		return $value;
	}

    private function format(mixed $value): string
    {
        if (is_bool($value)) {
            return $value ? 'yes' : 'no';
        }
        if (is_scalar($value) || $value === null || is_resource($value) || $value instanceof \Stringable) {
            return (string) $value;
        }

        return \Dogma\ExceptionValueFormatter::format($value);
    }

    public function __get(string $name): mixed
    {
        if (isset($this->profiles['@' . $name])) {
            return new ConfigurationProfile($this->profiles['@' . $name]);
        }
        if (!array_key_exists($name, $this->values)) {
            trigger_error("Value '$name' not found.");
            return null;
        }
        if (!isset($this->values[$name]) && isset($this->defaults[$name])) {
            return $this->defaults[$name];
        } else {
            return $this->values[$name];
        }
    }

    public function __isset(string $name): bool
    {
        if (isset($this->profiles['@' . $name])) {
            return true;
        }
        if (!array_key_exists($name, $this->values)) {
            trigger_error("Value '$name' not found.");
            return false;
        }
        if (isset($this->values[$name])) {
            return true;
        } elseif (isset($this->defaults[$name])) {
            return true;
        }
        return false;
    }

}
