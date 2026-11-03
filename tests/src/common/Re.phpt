<?php declare(strict_types = 1);

namespace Dogma\Tests\Str;

use Dogma\Re;
use Dogma\Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


pos:
Assert::same(Re::pos('abc@def', '~#~'), null);
Assert::same(Re::pos('abc@def', '~@~'), 3);
Assert::same(Re::pos('abc@def', '~@([def])~'), 3);

submatch:
Assert::same(Re::submatch('abc@def', '~(abc)~'), 'abc');
Assert::same(Re::submatch('abc@def', '~(def)~'), 'def');
Assert::same(Re::submatch('abc@def', '~(foo)~'), null);
Assert::same(Re::submatch('abc@def', '~(def)~', Re::CAPTURE_OFFSET), ['def', 4]);

hasMatch:
Assert::same(true, Re::hasMatch('abc@def', '~@~', 3));
Assert::same(false, Re::hasMatch('abc@def', '~a~', 3));
