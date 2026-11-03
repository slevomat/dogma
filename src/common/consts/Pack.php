<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma;

class Pack
{
    use StaticClassMixin;

    public const string NUL_STRING = 'a'; // NUL-padded string
    public const string SPACE_STRING = 'A'; // SPACE-padded string
    public const string HEX_LE = 'h'; // Hex string, low nibble first
    public const string HEX = 'H'; // Hex string, high nibble first
    public const string INT8 = 'c'; // signed char
    public const string UINT8 = 'C'; // unsigned char
    public const string INT16 = 's'; // signed short (always 16 bit, machine byte order)
    public const string UINT16 = 'S'; // unsigned short (always 16 bit, machine byte order)
    public const string UINT16_BE = 'n'; // unsigned short (always 16 bit, big endian byte order)
    public const string UINT16_LE = 'v'; // unsigned short (always 16 bit, little endian byte order)
    public const string INT = 'i'; // signed integer (machine dependent size and byte order)
    public const string UINT = 'I'; // unsigned integer (machine dependent size and byte order)
    public const string INT32 = 'l'; // signed long (always 32 bit, machine byte order)
    public const string UINT32 = 'L'; // unsigned long (always 32 bit, machine byte order)
    public const string UINT32_BE = 'N'; // unsigned long (always 32 bit, big endian byte order)
    public const string UINT32_LE = 'V'; // unsigned long (always 32 bit, little endian byte order)
    public const string INT64 = 'q'; // signed long long (always 64 bit, machine byte order)
    public const string UINT64 = 'Q'; // unsigned long long (always 64 bit, machine byte order)
    public const string UINT64_BE = 'J'; // unsigned long long (always 64 bit, big endian byte order)
    public const string UINT64_LE = 'P'; // unsigned long long (always 64 bit, little endian byte order)
    public const string FLOAT = 'f'; // float (machine dependent size and representation)
    public const string FLOAT_LE = 'g'; // float (machine dependent size, little endian byte order)
    public const string FLOAT_BE = 'G'; // float (machine dependent size, big endian byte order)
    public const string DOUBLE = 'd'; // double (machine dependent size and representation)
    public const string DOUBLE_LE = 'e'; // double (machine dependent size, little endian byte order)
    public const string DOUBLE_BE = 'E'; // double (machine dependent size, big endian byte order)
    public const string NUL = 'x'; // NUL byte
    public const string BACK = 'X'; // Back up one byte
    public const string NUL_STRING_ALIAS = 'Z'; // NUL-padded string (new in PHP 5.5)
    public const string NUL_FILL = '@'; // NUL-fill to absolute position

}
