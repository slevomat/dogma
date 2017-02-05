<?php
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Web;

use Dogma\Country\Country;
use Dogma\PartialEnum;

final class Tld extends PartialEnum
{

    // common TLD
    const COM = 'com';
    const ORG = 'org';
    const NET = 'net';
    const INT = 'int';
    const EDU = 'edu';
    const GOV = 'gov';
    const MIL = 'mil';

    // country TLD
    const AC = 'ac';
    const AD = 'ad';
    const AE = 'ae';
    const AF = 'af';
    const AG = 'ag';
    const AI = 'ai';
    const AL = 'al';
    const AM = 'am';
    const AN = 'an';
    const AO = 'ao';
    const AQ = 'aq';
    const AR = 'ar';
    const AS_TLD = 'as';
    const AT = 'at';
    const AU = 'au';
    const AW = 'aw';
    const AX = 'ax';
    const AZ = 'az';
    const BA = 'ba';
    const BB = 'bb';
    const BD = 'bd';
    const BE = 'be';
    const BF = 'bf';
    const BG = 'bg';
    const BH = 'bh';
    const BI = 'bi';
    const BJ = 'bj';
    const BM = 'bm';
    const BN = 'bn';
    const BO = 'bo';
    const BQ = 'bq';
    const BR = 'br';
    const BS = 'bs';
    const BT = 'bt';
    const BV = 'bv';
    const BW = 'bw';
    const BY = 'by';
    const BZ = 'bz';
    const BZH = 'bzh';
    const CA = 'ca';
    const CC = 'cc';
    const CD = 'cd';
    const CF = 'cf';
    const CG = 'cg';
    const CH = 'ch';
    const CI = 'ci';
    const CK = 'ck';
    const CL = 'cl';
    const CM = 'cm';
    const CN = 'cn';
    const CO = 'co';
    const CR = 'cr';
    const CS = 'cs';
    const CU = 'cu';
    const CV = 'cv';
    const CW = 'cw';
    const CX = 'cx';
    const CY = 'cy';
    const CZ = 'cz';
    const DD = 'dd';
    const DE = 'de';
    const DJ = 'dj';
    const DK = 'dk';
    const DM = 'dm';
    const DO_TLD = 'do';
    const DZ = 'dz';
    const EC = 'ec';
    const EE = 'ee';
    const EG = 'eg';
    const EH = 'eh';
    const ER = 'er';
    const ES = 'es';
    const ET = 'et';
    const EU = 'eu';
    const FI = 'fi';
    const FJ = 'fj';
    const FK = 'fk';
    const FM = 'fm';
    const FO = 'fo';
    const FR = 'fr';
    const GA = 'ga';
    const GB = 'gb';
    const GD = 'gd';
    const GE = 'ge';
    const GF = 'gf';
    const GG = 'gg';
    const GH = 'gh';
    const GI = 'gi';
    const GL = 'gl';
    const GM = 'gm';
    const GN = 'gn';
    const GP = 'gp';
    const GQ = 'gq';
    const GR = 'gr';
    const GS = 'gs';
    const GT = 'gt';
    const GU = 'gu';
    const GW = 'gw';
    const GY = 'gy';
    const HK = 'hk';
    const HM = 'hm';
    const HN = 'hn';
    const HR = 'hr';
    const HT = 'ht';
    const HU = 'hu';
    const ID = 'id';
    const IE = 'ie';
    const IL = 'il';
    const IM = 'im';
    const IN = 'in';
    const IO = 'io';
    const IQ = 'iq';
    const IR = 'ir';
    const IS = 'is';
    const IT = 'it';
    const JE = 'je';
    const JM = 'jm';
    const JO = 'jo';
    const JP = 'jp';
    const KE = 'ke';
    const KG = 'kg';
    const KH = 'kh';
    const KI = 'ki';
    const KM = 'km';
    const KN = 'kn';
    const KP = 'kp';
    const KR = 'kr';
    const KRD = 'krd';
    const KW = 'kw';
    const KY = 'ky';
    const KZ = 'kz';
    const LA = 'la';
    const LB = 'lb';
    const LC = 'lc';
    const LI = 'li';
    const LK = 'lk';
    const LR = 'lr';
    const LS = 'ls';
    const LT = 'lt';
    const LU = 'lu';
    const LV = 'lv';
    const LY = 'ly';
    const MA = 'ma';
    const MC = 'mc';
    const MD = 'md';
    const ME = 'me';
    const MG = 'mg';
    const MH = 'mh';
    const MK = 'mk';
    const ML = 'ml';
    const MM = 'mm';
    const MN = 'mn';
    const MO = 'mo';
    const MP = 'mp';
    const MQ = 'mq';
    const MR = 'mr';
    const MS = 'ms';
    const MT = 'mt';
    const MU = 'mu';
    const MV = 'mv';
    const MW = 'mw';
    const MX = 'mx';
    const MY = 'my';
    const MZ = 'mz';
    const NA = 'na';
    const NC = 'nc';
    const NE = 'ne';
    const NF = 'nf';
    const NG = 'ng';
    const NI = 'ni';
    const NL = 'nl';
    const NO = 'no';
    const NP = 'np';
    const NR = 'nr';
    const NU = 'nu';
    const NZ = 'nz';
    const OM = 'om';
    const PA = 'pa';
    const PE = 'pe';
    const PF = 'pf';
    const PG = 'pg';
    const PH = 'ph';
    const PK = 'pk';
    const PL = 'pl';
    const PM = 'pm';
    const PN = 'pn';
    const PR = 'pr';
    const PS = 'ps';
    const PT = 'pt';
    const PW = 'pw';
    const PY = 'py';
    const QA = 'qa';
    const RE = 're';
    const RO = 'ro';
    const RS = 'rs';
    const RU = 'ru';
    const RW = 'rw';
    const SA = 'sa';
    const SB = 'sb';
    const SC = 'sc';
    const SD = 'sd';
    const SE = 'se';
    const SG = 'sg';
    const SH = 'sh';
    const SI = 'si';
    const SJ = 'sj';
    const SK = 'sk';
    const SL = 'sl';
    const SM = 'sm';
    const SN = 'sn';
    const SO = 'so';
    const SR = 'sr';
    const SS = 'ss';
    const ST = 'st';
    const SU = 'su';
    const SV = 'sv';
    const SX = 'sx';
    const SY = 'sy';
    const SZ = 'sz';
    const TC = 'tc';
    const TD = 'td';
    const TF = 'tf';
    const TG = 'tg';
    const TH = 'th';
    const TJ = 'tj';
    const TK = 'tk';
    const TL = 'tl';
    const TM = 'tm';
    const TN = 'tn';
    const TO = 'to';
    const TP = 'tp';
    const TR = 'tr';
    const TT = 'tt';
    const TV = 'tv';
    const TW = 'tw';
    const TZ = 'tz';
    const UA = 'ua';
    const UG = 'ug';
    const UK = 'uk';
    const US = 'us';
    const UY = 'uy';
    const UZ = 'uz';
    const VA = 'va';
    const VC = 'vc';
    const VE = 've';
    const VG = 'vg';
    const VI = 'vi';
    const VN = 'vn';
    const VU = 'vu';
    const WF = 'wf';
    const WS = 'ws';
    const YE = 'ye';
    const YT = 'yt';
    const YU = 'yu';
    const ZA = 'za';
    const ZM = 'zm';
    const ZR = 'zr';
    const ZW = 'zw';

    /** @var string[] */
    private static $countryMap = [
        self::AC => Country::SAINT_HELENA,
        self::AD => Country::ANDORRA,
        self::AE => Country::UNITED_ARAB_EMIRATES,
        self::AF => Country::AFGHANISTAN,
        self::AG => Country::ANTIGUA_AND_BARBUDA,
        self::AI => Country::ANGUILLA,
        self::AL => Country::ALBANIA,
        self::AM => Country::ARMENIA,
        self::AN => Country::NETHERLANDS_ANTILLES,
        self::AO => Country::ANGOLA,
        self::AQ => Country::ANTARCTICA,
        self::AR => Country::ARGENTINA,
        self::AS_TLD => Country::AMERICAN_SAMOA,
        self::AT => Country::AUSTRIA,
        self::AU => Country::AUSTRALIA,
        self::AW => Country::ARUBA,
        self::AX => Country::ALAND_ISLANDS,
        self::AZ => Country::AZERBAIJAN,
        self::BA => Country::BOSNIA_AND_HERZEGOVINA,
        self::BB => Country::BARBADOS,
        self::BD => Country::BANGLADESH,
        self::BE => Country::BELGIUM,
        self::BF => Country::BURKINA_FASO,
        self::BG => Country::BULGARIA,
        self::BH => Country::BAHRAIN,
        self::BI => Country::BURUNDI,
        self::BJ => Country::BENIN,
        self::BM => Country::BERMUDA,
        self::BN => Country::BRUNEI_DARUSSALAM,
        self::BO => Country::BOLIVIA,
        self::BQ => Country::NETHERLANDS,
        self::BR => Country::BRAZIL,
        self::BS => Country::BAHAMAS,
        self::BT => Country::BHUTAN,
        self::BV => Country::BOUVET_ISLAND,
        self::BW => Country::BOTSWANA,
        self::BY => Country::BELARUS,
        self::BZ => Country::BELIZE,
        self::BZH => Country::FRANCE,
        self::CA => Country::CANADA,
        self::CC => Country::COCOS_ISLANDS,
        self::CD => Country::DEMOCRATIC_REPUBLIC_OF_THE_CONGO,
        self::CF => Country::CENTRAL_AFRICAN_REPUBLIC,
        self::CG => Country::CONGO,
        self::CH => Country::SWITZERLAND,
        self::CI => Country::COTE_D_IVOIRE,
        self::CK => Country::COOK_ISLANDS,
        self::CL => Country::CHILE,
        self::CM => Country::CAMEROON,
        self::CN => Country::CHINA,
        self::CO => Country::COLOMBIA,
        self::CR => Country::COSTA_RICA,
        self::CU => Country::CUBA,
        self::CV => Country::CAPE_VERDE,
        self::CW => Country::NETHERLANDS,
        self::CX => Country::CHRISTMAS_ISLAND,
        self::CY => Country::CYPRUS,
        self::CZ => Country::CZECHIA,
        self::DD => Country::GERMANY,
        self::DE => Country::GERMANY,
        self::DJ => Country::DJIBOUTI,
        self::DK => Country::DENMARK,
        self::DM => Country::DOMINICA,
        self::DO_TLD => Country::DOMINICAN_REPUBLIC,
        self::DZ => Country::ALGERIA,
        self::EC => Country::ECUADOR,
        self::EE => Country::ESTONIA,
        self::EG => Country::EGYPT,
        self::EH => Country::WESTERN_SAHARA,
        self::ER => Country::ERITREA,
        self::ES => Country::SPAIN,
        self::ET => Country::ETHIOPIA,
        self::FI => Country::FINLAND,
        self::FJ => Country::FIJI,
        self::FK => Country::FALKLAND_ISLANDS,
        self::FM => Country::MICRONESIA,
        self::FO => Country::FAROE_ISLANDS,
        self::FR => Country::FRANCE,
        self::GA => Country::GABON,
        self::GB => Country::UNITED_KINGDOM,
        self::GD => Country::GRENADA,
        self::GE => Country::GEORGIA,
        self::GF => Country::FRENCH_GUIANA,
        self::GG => Country::GUERNSEY,
        self::GH => Country::GHANA,
        self::GI => Country::GIBRALTAR,
        self::GL => Country::GREENLAND,
        self::GM => Country::GAMBIA,
        self::GN => Country::GUINEA,
        self::GP => Country::GUADELOUPE,
        self::GQ => Country::EQUATORIAL_GUINEA,
        self::GR => Country::GREECE,
        self::GS => Country::SOUTH_GEORGIA_AND_THE_SOUTH_SANDWICH,
        self::GT => Country::GUATEMALA,
        self::GU => Country::GUAM,
        self::GW => Country::GUINEA_BISSAU,
        self::GY => Country::GUYANA,
        self::HK => Country::HONG_KONG,
        self::HM => Country::HEARD_ISLAND_AND_MCDONALD_ISLANDS,
        self::HN => Country::HONDURAS,
        self::HR => Country::CROATIA,
        self::HT => Country::HAITI,
        self::HU => Country::HUNGARY,
        self::ID => Country::INDONESIA,
        self::IE => Country::IRELAND,
        self::IL => Country::ISRAEL,
        self::IM => Country::ISLE_OF_MAN,
        self::IN => Country::INDIA,
        self::IO => Country::BRITISH_INDIAN_OCEAN_TERRITORY,
        self::IQ => Country::IRAQ,
        self::IR => Country::ISLAMIC_REPUBLIC_OF_IRAN,
        self::IS => Country::ICELAND,
        self::IT => Country::ITALY,
        self::JE => Country::JERSEY,
        self::JM => Country::JAMAICA,
        self::JO => Country::JORDAN,
        self::JP => Country::JAPAN,
        self::KE => Country::KENYA,
        self::KG => Country::KYRGYZSTAN,
        self::KH => Country::CAMBODIA,
        self::KI => Country::KIRIBATI,
        self::KM => Country::COMOROS,
        self::KN => Country::SAINT_KITTS_AND_NEVIS,
        self::KP => Country::NORTH_KOREA,
        self::KR => Country::SOUTH_KOREA,
        self::KW => Country::KUWAIT,
        self::KY => Country::CAYMAN_ISLANDS,
        self::KZ => Country::KAZAKHSTAN,
        self::LA => Country::LAOS,
        self::LB => Country::LEBANON,
        self::LC => Country::SAINT_LUCIA,
        self::LI => Country::LIECHTENSTEIN,
        self::LK => Country::SRI_LANKA,
        self::LR => Country::LIBERIA,
        self::LS => Country::LESOTHO,
        self::LT => Country::LITHUANIA,
        self::LU => Country::LUXEMBOURG,
        self::LV => Country::LATVIA,
        self::LY => Country::LIBYA,
        self::MA => Country::MOROCCO,
        self::MC => Country::MONACO,
        self::MD => Country::MOLDOVA,
        self::ME => Country::MONTENEGRO,
        self::MG => Country::MADAGASCAR,
        self::MH => Country::MARSHALL_ISLANDS,
        self::MK => Country::MACEDONIA,
        self::ML => Country::MALI,
        self::MM => Country::MYANMAR,
        self::MN => Country::MONGOLIA,
        self::MO => Country::MACAO,
        self::MP => Country::NORTHERN_MARIANA_ISLANDS,
        self::MQ => Country::MARTINIQUE,
        self::MR => Country::MAURITANIA,
        self::MS => Country::MONTSERRAT,
        self::MT => Country::MALTA,
        self::MU => Country::MAURITIUS,
        self::MV => Country::MALDIVES,
        self::MW => Country::MALAWI,
        self::MX => Country::MEXICO,
        self::MY => Country::MALAYSIA,
        self::MZ => Country::MOZAMBIQUE,
        self::NA => Country::NAMIBIA,
        self::NC => Country::NEW_CALEDONIA,
        self::NE => Country::NIGER,
        self::NF => Country::NORFOLK_ISLAND,
        self::NG => Country::NIGERIA,
        self::NI => Country::NICARAGUA,
        self::NL => Country::NETHERLANDS,
        self::NO => Country::NORWAY,
        self::NP => Country::NEPAL,
        self::NR => Country::NAURU,
        self::NU => Country::NIUE,
        self::NZ => Country::NEW_ZEALAND,
        self::OM => Country::OMAN,
        self::PA => Country::PANAMA,
        self::PE => Country::PERU,
        self::PF => Country::FRENCH_POLYNESIA,
        self::PG => Country::PAPUA_NEW_GUINEA,
        self::PH => Country::PHILIPPINES,
        self::PK => Country::PAKISTAN,
        self::PL => Country::POLAND,
        self::PM => Country::SAINT_PIERRE_AND_MIQUELON,
        self::PN => Country::PITCAIRN,
        self::PR => Country::PUERTO_RICO,
        self::PS => Country::PALESTINE,
        self::PT => Country::PORTUGAL,
        self::PW => Country::PALAU,
        self::PY => Country::PARAGUAY,
        self::QA => Country::QATAR,
        self::RE => Country::REUNION,
        self::RO => Country::ROMANIA,
        self::RS => Country::SERBIA,
        self::RU => Country::RUSSIA,
        self::RW => Country::RWANDA,
        self::SA => Country::SAUDI_ARABIA,
        self::SB => Country::SOLOMON_ISLANDS,
        self::SC => Country::SEYCHELLES,
        self::SD => Country::SUDAN,
        self::SE => Country::SWEDEN,
        self::SG => Country::SINGAPORE,
        self::SH => Country::SAINT_HELENA,
        self::SI => Country::SLOVENIA,
        self::SJ => Country::SVALBARD_AND_JAN_MAYEN,
        self::SK => Country::SLOVAKIA,
        self::SL => Country::SIERRA_LEONE,
        self::SM => Country::SAN_MARINO,
        self::SN => Country::SENEGAL,
        self::SO => Country::SOMALIA,
        self::SR => Country::SURINAME,
        self::SS => Country::SOUTH_SUDAN,
        self::ST => Country::SAO_TOME_AND_PRINCIPE,
        self::SV => Country::EL_SALVADOR,
        self::SX => Country::NETHERLANDS,
        self::SY => Country::SYRIA,
        self::SZ => Country::SWAZILAND,
        self::TC => Country::TURKS_AND_CAICOS_ISLANDS,
        self::TD => Country::CHAD,
        self::TF => Country::FRENCH_SOUTHERN_TERRITORIES,
        self::TG => Country::TOGO,
        self::TH => Country::THAILAND,
        self::TJ => Country::TAJIKISTAN,
        self::TK => Country::TOKELAU,
        self::TL => Country::TIMOR_LESTE,
        self::TM => Country::TURKMENISTAN,
        self::TN => Country::TUNISIA,
        self::TO => Country::TONGA,
        self::TP => Country::TIMOR_LESTE,
        self::TR => Country::TURKEY,
        self::TT => Country::TRINIDAD_AND_TOBAGO,
        self::TV => Country::TUVALU,
        self::TW => Country::TAIWAN,
        self::TZ => Country::TANZANIA,
        self::UA => Country::UKRAINE,
        self::UG => Country::UGANDA,
        self::UK => Country::UNITED_KINGDOM,
        self::US => Country::UNITED_STATES,
        self::UY => Country::URUGUAY,
        self::UZ => Country::UZBEKISTAN,
        self::VA => Country::VATICAN,
        self::VC => Country::SAINT_VINCENT_AND_THE_GRENADINES,
        self::VE => Country::VENEZUELA,
        self::VG => Country::VIRGIN_ISLANDS_BRITISH,
        self::VI => Country::VIRGIN_ISLANDS_US,
        self::VN => Country::VIETNAM,
        self::VU => Country::VANUATU,
        self::WF => Country::WALLIS_AND_FUTUNA,
        self::WS => Country::SAMOA,
        self::YE => Country::YEMEN,
        self::YT => Country::MAYOTTE,
        self::ZA => Country::SOUTH_AFRICA,
        self::ZM => Country::ZAMBIA,
        self::ZR => Country::DEMOCRATIC_REPUBLIC_OF_THE_CONGO,
        self::ZW => Country::ZIMBABWE,
    ];

    public function isCountryTld(): bool
    {
        return strlen($this->getValue()) === 2 || $this->equals(self::BZH);
    }

    public function getCountry(): ?Country
    {
        $value = $this->getValue();
        if (isset(self::$countryMap[$value])) {
            return Country::get(self::$countryMap[$value]);
        }
        return null;
    }

    public static function getByCountry(Country $country): self
    {
        return self::get(array_search($country->getValue(), self::$countryMap));
    }

    public static function getValueRegexp(): string
    {
        return '^([a-z]{2,}|xn--[0-9a-z]{4,})$';
    }

}
