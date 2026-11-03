<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

// spell-check-ignore: euccn eucjp eucjpwin euckr euctw jisms koi8r koi8t koi8u sjismac sjiswin utf7imap

namespace Dogma\Language;

use function preg_match;
use function str_replace;
use function strtolower;
use function strtoupper;

/**
 * Encoding codes accepted by mbstring and iconv (except BINARY; not all of them)
 */
enum Encoding: string
{

    case Binary = 'BINARY';

    case Ascii = 'ASCII';

    case Utf8 = 'UTF-8';

    case Utf7 = 'UTF-7';
    case Utf7Imap = 'UTF7-IMAP';

    case Utf16 = 'UTF-16';
    case Utf16be = 'UTF-16BE';
    case Utf16le = 'UTF-16LE';

    case Utf32 = 'UTF-32';
    case Utf32be = 'UTF-32BE';
    case Utf32le = 'UTF-32LE';

    case Ucs2 = 'UCS-2';
    case Ucs2be = 'UCS-2BE';
    case Ucs2le = 'UCS-2LE';

    case Ucs4 = 'UCS-4';
    case Ucs4be = 'UCS-4BE';
    case Ucs4le = 'UCS-4LE';

    case Iso88591 = 'ISO-8859-1'; // Latin-1 Western European
    case Iso88592 = 'ISO-8859-2'; // Latin-2 Central European
    case Iso88593 = 'ISO-8859-3'; // Latin-3 South European
    case Iso88594 = 'ISO-8859-4'; // Latin-4 North European
    case Iso88595 = 'ISO-8859-5'; // Latin/Cyrillic
    case Iso88596 = 'ISO-8859-6'; // Latin/Arabic
    case Iso88597 = 'ISO-8859-7'; // Latin/Greek
    case Iso88598 = 'ISO-8859-8'; // Latin/Hebrew
    case Iso88599 = 'ISO-8859-9'; // Latin-5 Turkish
    case Iso885910 = 'ISO-8859-10'; // Latin-6 Nordic
    case Iso885911 = 'ISO-8859-11'; // Latin/Thai
    case Iso885913 = 'ISO-8859-13'; // Latin-7 Baltic Rim
    case Iso885914 = 'ISO-8859-14'; // Latin-8 Celtic
    case Iso885915 = 'ISO-8859-15'; // Latin-9
    case Iso885916 = 'ISO-8859-16'; // Latin-10 South-Eastern European

    case Windows1250 = 'WINDOWS-1250'; // Latin 2 / Central European
    case Windows1251 = 'WINDOWS-1251'; // Cyrillic
    case Windows1252 = 'WINDOWS-1252'; // Latin 1 / Western European
    case Windows1253 = 'WINDOWS-1253'; // Greek
    case Windows1254 = 'WINDOWS-1254'; // Turkish
    case Windows1255 = 'WINDOWS-1255'; // Hebrew
    case Windows1256 = 'WINDOWS-1256'; // Arabic
    case Windows1257 = 'WINDOWS-1257'; // Baltic
    case Windows1258 = 'WINDOWS-1258'; // Vietnamese

    case Cp850 = 'CP850'; // DOS Latin 1 Western European
    case Cp852 = 'CP852'; // DOS Latin 2 Central European
    case Cp862 = 'CP862'; // DOS Hebrew
    case Cp866 = 'CP866'; // DOS Cyrillic
    case Cp932 = 'CP932'; // IBM SJIS
    case Cp936 = 'CP936'; // IBM Simplified Chinese
    case Cp950 = 'CP950'; // MS BIG-5

    case Cp50220 = 'CP50220';
    case Cp50221 = 'CP50221';
    case Cp50222 = 'CP50222';
    case Cp51932 = 'CP51932';

    case EucJp = 'EUC-JP';
    case EucJpWin = 'EUC-JP-WIN';
    case EucJp2004 = 'EUC-JP-2004';
    case EucCn = 'EUC-CN';
    case EucTw = 'EUC-TW';
    case EucKr = 'EUC-KR';

    case Jis = 'JIS';
    case JisMs = 'JIS-MS';

    case Sjis = 'SJIS';
    case SjisWin = 'SJIS-WIN';
    case SjisMac = 'SJIS-MAC';
    case Sjis2004 = 'SJIS-2004';

    case Iso2022Jp = 'ISO-2022-JP';
    case Iso2022JpMs = 'ISO-2022-JP-MS';
    case Iso2022Jp2004 = 'ISO-2022-JP-2004';
    case Iso2022Kr = 'ISO-2022-KR';

    case Koi8R = 'KOI8-R';
    case Koi8U = 'KOI8-U';
    case Koi8T = 'KOI8-T';

    case Gb18030 = 'GB18030';

    case Big5 = 'BIG-5';

    case Uhc = 'UHC';

    case Hz = 'HZ';

    case Armscii8 = 'ARMSCII-8';

    private const array ALIASES = [
        'bin' => self::Binary->value,
        'binary' => self::Binary->value,
        'ascii' => self::Ascii->value,
        'utf8' => self::Utf8->value,
        'utf7' => self::Utf7->value,
        'utf7imap' => self::Utf7Imap->value,
        'utf16' => self::Utf16->value,
        'utf16be' => self::Utf16be->value,
        'utf16le' => self::Utf16le->value,
        'utf32' => self::Utf32->value,
        'utf32be' => self::Utf32be->value,
        'utf32le' => self::Utf32le->value,
        'ucs2' => self::Ucs2->value,
        'ucs2be' => self::Ucs2be->value,
        'ucs2le' => self::Ucs2le->value,
        'ucs4' => self::Ucs4->value,
        'ucs4be' => self::Ucs4be->value,
        'ucs4le' => self::Ucs4le->value,
        'iso88591' => self::Iso88591->value,
        'latin1' => self::Iso88591->value,
        'iso88592' => self::Iso88592->value,
        'latin2' => self::Iso88592->value,
        'iso88593' => self::Iso88593->value,
        'latin3' => self::Iso88593->value,
        'iso88594' => self::Iso88594->value,
        'latin4' => self::Iso88594->value,
        'iso88595' => self::Iso88595->value, // Latin/Cyrillic
        'iso88596' => self::Iso88596->value, // Latin/Arabic
        'iso88597' => self::Iso88597->value, // Latin/Greek
        'iso88598' => self::Iso88598->value, // Latin/Hebrew
        'iso88599' => self::Iso88599->value,
        'latin5' => self::Iso88599->value,
        'iso885910' => self::Iso885910->value,
        'latin6' => self::Iso885910->value,
        'iso885911' => self::Iso885911->value, // Latin/Thai
        'iso885913' => self::Iso885913->value,
        'latin7' => self::Iso885913->value,
        'iso885914' => self::Iso885914->value,
        'latin8' => self::Iso885914->value,
        'iso885915' => self::Iso885915->value,
        'latin9' => self::Iso885915->value,
        'iso885916' => self::Iso885916->value,
        'latin10' => self::Iso885916->value,
        'windows1250' => self::Windows1250->value, // Latin 2 / Central European
        'windows1251' => self::Windows1251->value, // Cyrillic
        'windows1252' => self::Windows1252->value, // Latin 1 / Western European
        'windows1253' => self::Windows1253->value, // Greek
        'windows1254' => self::Windows1254->value, // Turkish
        'windows1255' => self::Windows1255->value, // Hebrew
        'windows1256' => self::Windows1256->value, // Arabic
        'windows1257' => self::Windows1257->value, // Baltic
        'windows1258' => self::Windows1258->value, // Vietnamese
        'cp850' => self::Cp850->value, // DOS Latin 1 Western European
        'cp852' => self::Cp852->value, // DOS Latin 2 Central European
        'cp862' => self::Cp862->value, // DOS Hebrew
        'cp866' => self::Cp866->value, // DOS Cyrillic
        'cp932' => self::Cp932->value, // IBM SJIS
        'cp936' => self::Cp936->value, // IBM Simplified Chinese
        'cp950' => self::Cp950->value, // MS BIG-5
        'cp50220' => self::Cp50220->value,
        'cp50221' => self::Cp50221->value,
        'cp50222' => self::Cp50222->value,
        'cp51932' => self::Cp51932->value,
        'eucjp' => self::EucJp->value,
        'eucjpwin' => self::EucJpWin->value,
        'eucjp2004' => self::EucJp2004->value,
        'euccn' => self::EucCn->value,
        'euctw' => self::EucTw->value,
        'euckr' => self::EucKr->value,
        'jis' => self::Jis->value,
        'jisms' => self::JisMs->value,
        'sjis' => self::Sjis->value,
        'sjiswin' => self::SjisWin->value,
        'sjismac' => self::SjisMac->value,
        'sjis2004' => self::Sjis2004->value,
        'iso2022jp' => self::Iso2022Jp->value,
        'iso2022jpms' => self::Iso2022JpMs->value,
        'iso2022jp2004' => self::Iso2022Jp2004->value,
        'iso2022kr' => self::Iso2022Kr->value,
        'koi8r' => self::Koi8R->value,
        'koi8u' => self::Koi8U->value,
        'koi8t' => self::Koi8T->value,
        'gb18030' => self::Gb18030->value,
        'big5' => self::Big5->value,
        'uhc' => self::Uhc->value,
        'hz' => self::Hz->value,
        'armscii8' => self::Armscii8->value,
    ];

    private const array UNUSED = [
        self::Iso88591->value => "~[\x7F-\xFF]~",
        self::Iso88592->value => "~[\x7F-\xFF]~",
        self::Iso88593->value => "~[\x7F-\xFF\xA5\xAE\xBE\xC3\xD0\xE3\xF0]~",
        self::Iso88594->value => "~[\x7F-\xFF]~",
        self::Iso88595->value => "~[\x7F-\xFF]~",
        self::Iso88596->value => "~[\x7F-\xFF\xA1-\xA3\xA5-\xAB\xAE-\xBA\xBC-\xBE\xC0\xDB-\xDF\xF3-\xFF]~",
        self::Iso88597->value => "~[\x7F-\xFF\xAE\xD2\xFF]~",
        self::Iso88598->value => "~[\x7F-\xFF\xA1\xBF-\xDE\xFB\xFC\xFF]~",
        self::Iso88599->value => "~[\x7F-\xFF]~",
        self::Iso885910->value => "~[\x7F-\xFF]~",
        self::Iso885911->value => "~[\x7F-\xFF\xDB-\xDE\xFC-\xFF]~",
        self::Iso885913->value => "~[\x7F-\xFF]~",
        self::Iso885914->value => "~[\x7F-\xFF]~",
        self::Iso885915->value => "~[\x7F-\xFF]~",
        self::Iso885916->value => "~[\x7F-\xFF]~",
        self::Windows1250->value => "~[\x81\x83\x88\x90\x98]~",
        self::Windows1251->value => "~[\x98]~",
        self::Windows1252->value => "~[\x81\x8D\x8F\x90\x9D]~",
        self::Windows1253->value => "~[\x81\x88\x8A\x8C-\x8F\x90\x98\x9A\x9C-\x9F\xAA\xD2\xFF]~",
        self::Windows1254->value => "~[\x81\x8D-\x8F\x90\x9D\x9E]~",
        self::Windows1255->value => "~[\x81\x8A\x8C-\x8F\x90\x9A\x9C-\x9F\xD9-\xDE\xFB\xFC\xFF]~",
        self::Windows1256->value => "~^(?!x)x~", // match nothing
        self::Windows1257->value => "~[\x81\x83\x88\x8A\x8C\x90\x98\x9A\x9C\x9F\xA1\xA5]~",
        self::Windows1258->value => "~[\x81\x8A\x8D-\x8F\x90\x9A\x9D\x9E]~",
        self::Cp850->value => "~^(?!x)x~", // match nothing
        self::Cp852->value => "~^(?!x)x~", // match nothing
        self::Cp862->value => "~^(?!x)x~", // match nothing
        self::Cp866->value => "~^(?!x)x~", // match nothing
    ];

    public static function parse(string $value): self
    {
        return self::from(self::normalize($value));
    }

    public static function getValueRegexp(): string
    {
        return 'BINARY|ASCII|UTF-(?:8|7(?:-IMAP)?|(?:(?:16|32)(?:BE|LE)?))|UCS-[24](?:BE|LE)'
            . '|ISO-8859-(?:1(0-6)?|[2-9])|WINDOWS-125[0-8]|CP[89]\\d\\d|CP5022[012]|CP51932'
            . '|EUC-(?:JP(?:-2004)?|CN|TW|KR)|EUC-JP-WIN|JIS(?:-MS)?|SJIS(?:-WIN|-MAC|2004)?'
            . '|ISO-2022-(?:JP(?:-MS|-2004)?|KR)|KOI8-[RUT]|GB18030|BIG-5|UHC|HZ|ARMSCII-8';
    }

    public static function normalize(string $encoding): string
    {
        $encoding = strtolower(str_replace(['-', '_'], '', $encoding));

        return self::ALIASES[$encoding] ?? strtoupper($encoding);
    }

    public static function canCheck(string $encoding): bool
    {
        $encoding = self::normalize($encoding);

        return isset(self::UNUSED[$encoding]);
    }

    public static function check(string $value, string $encoding): bool
    {
        $encoding = self::normalize($encoding);

        $regexp = self::UNUSED[$encoding] ?? null;
        if ($regexp === null) {
            return false;
        }

        return preg_match($regexp, $value) === 0;
    }

}
