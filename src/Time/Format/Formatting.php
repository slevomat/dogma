<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

// spell-check-ignore: FRI PÁ Únor pátek pátku od dubna duben

namespace Dogma\Time\Format;

use Dogma\StrictBehaviorMixin;

class Formatting
{
    use StrictBehaviorMixin;

    public const string ESCAPE_CHARACTER = '\\';

    // variables inside block [] must not contain only zeros. otherwise the block is removed
    // e.g. "1.12.2017[ 00:00]" is converted to "1.12.2017"
    public const string NO_ZEROS_GROUP_START = '[';
    public const string NO_ZEROS_GROUP_END = ']';

    // variables inside block () must be different than current time. otherwise the block is removed
    // e.g. "1.12.(2017)" is converted to "1.12." if the current year is 2017, otherwise to "1.12.2017"
    public const string OPTIONAL_GROUP_START = '(';
    public const string OPTIONAL_GROUP_END = ')';

    // variables inside block {} must be different from other date from the pair. otherwise the block is removed
    // e.g. "1.12.{2017} - 31.12.2017" is converted to "1.12. - 31.12.2017"
    public const string NO_DUPLICATION_GROUP_START = '{';
    public const string NO_DUPLICATION_GROUP_END = '}';

    // print word with upper case letter
    // - e.g. "c^" --> "FRI", "PÁ"
    public const string UPPER_MODIFIER = '^';

    // print word with first upper case letter
    // - e.g. "N!" --> "February", "Únor"
    public const string CAPITALIZE_MODIFIER = '!';

    // grammatical case used after 'at'
    // - e.g. "C=" --> "at friday", "v pátek"
    public const string WHEN_MODIFIER = '=';

    // grammatical case used after 'until'
    // - e.g. "C<" --> "until friday", "do pátku"
    public const string SINCE_MODIFIER = '<';

    // grammatical case used after 'since'
    // - e.g. "C>" --> "since friday", "od pátku"
    public const string UNTIL_MODIFIER = '>';

    // grammatical case used after "of" for names and ordinal suffix or dot for numbers
    // - e.g. "d* N*" --> "27th of april", "27. dubna"
    // - e.g. "N d*" --> "april 27th", "duben 27."
    public const string ORDINAL_MODIFIER = '*';

}
