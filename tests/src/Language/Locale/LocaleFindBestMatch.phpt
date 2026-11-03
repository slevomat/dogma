<?php declare(strict_types = 1);

namespace Dogma\Tests\Language\Locale;

use Dogma\Language\Locale\Locale;
use Dogma\Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

$locale = Locale::get('en');
$match = $locale->findBestMatch([Locale::get('en'), Locale::get('cs')]);

Assert::same($match?->getValue(), 'en');
