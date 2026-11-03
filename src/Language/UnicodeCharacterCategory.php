<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Language;

enum UnicodeCharacterCategory: string
{

    case Other = 'C';
    case Control = 'Cc';
    case Format = 'Cf';
    case PrivateUse = 'Co';
    case Surrogate = 'Cs';

    case Letter = 'L';
    case LowerCaseLetter = 'Ll';
    case ModifierLetter = 'Lm';
    case OtherLetter = 'Lo';
    case TitleCaseLetter = 'Lt';
    case UpperCaseLetter = 'Lu';

    case Mark = 'M';
    case SpacingMark = 'Mc';
    case EnclosingMark = 'Me';
    case NonspacingMark = 'Mn';

    case Number = 'N';
    case DecimalNumber = 'Nd';
    case LetterNumber = 'Nl';
    case OtherNumber = 'No';

    case Punctuation = 'P';
    case ConnectorPunctuation = 'Pc';
    case DashPunctuation = 'Pd';
    case ClosePunctuation = 'Pe';
    case FinalPunctuation = 'Pf';
    case InitialPunctuation = 'Pi';
    case OtherPunctuation = 'Po';
    case OpenPunctuation = 'Ps';

    case Symbol = 'S';
    case CurrencySymbol = 'Sc';
    case ModifierSymbol = 'Sk';
    case MathSymbol = 'Sm';
    case OtherSymbol = 'So';

    case Separator = 'Z';
    case LineSeparator = 'Zl';
    case ParagraphSeparator = 'Zp';
    case SpaceSeparator = 'Zs';

    private const array NAMES = [
        self::Other->value => 'Other',
        self::Control->value => 'Control',
        self::Format->value => 'Format',
        self::PrivateUse->value => 'Private Use',
        self::Surrogate->value => 'Surrogate',
        self::Letter->value => 'Letter',
        self::LowerCaseLetter->value => 'Lower case Letter',
        self::ModifierLetter->value => 'Modifier Letter',
        self::OtherLetter->value => 'Other Letter',
        self::TitleCaseLetter->value => 'Title case Letter',
        self::UpperCaseLetter->value => 'Upper case Letter',
        self::Mark->value => 'Mark',
        self::SpacingMark->value => 'Spacing Mark',
        self::EnclosingMark->value => 'Enclosing Mark',
        self::NonspacingMark->value => 'Nonspacing Mark',
        self::Number->value => 'Number',
        self::DecimalNumber->value => 'Decimal Number',
        self::LetterNumber->value => 'Letter Number',
        self::OtherNumber->value => 'Other Number',
        self::Punctuation->value => 'Punctuation',
        self::ConnectorPunctuation->value => 'Connector Punctuation',
        self::DashPunctuation->value => 'Dash Punctuation',
        self::ClosePunctuation->value => 'Close Punctuation',
        self::FinalPunctuation->value => 'Final Punctuation',
        self::InitialPunctuation->value => 'Initial Punctuation',
        self::OtherPunctuation->value => 'Other Punctuation',
        self::OpenPunctuation->value => 'Open Punctuation',
        self::Symbol->value => 'Symbol',
        self::CurrencySymbol->value => 'Currency Symbol',
        self::ModifierSymbol->value => 'Modifier Symbol',
        self::MathSymbol->value => 'Math Symbol',
        self::OtherSymbol->value => 'Other Symbol',
        self::Separator->value => 'Separator',
        self::LineSeparator->value => 'Line Separator',
        self::ParagraphSeparator->value => 'Paragraph Separator',
        self::SpaceSeparator->value => 'Space Separator',
    ];

    public function getName(): string
    {
        return self::NAMES[$this->value];
    }

}
