<?php declare(strict_types = 1);

namespace Dogma\Tests\Time\Span;

use Dogma\Tester\Assert;
use Dogma\Time\Span\DateSpan;
use Dogma\Time\Span\TimeSpan;

require_once __DIR__ . '/../../bootstrap.php';

Assert::equal((new DateSpan(2))->subtract(new DateSpan(1)), new DateSpan(1));
Assert::equal((new TimeSpan(3))->subtract(new TimeSpan(1)), new TimeSpan(2));
