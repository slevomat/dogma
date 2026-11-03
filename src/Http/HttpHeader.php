<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

// spell-check-ignore: DNT TSV ATT PROTO Proto UIDH deviceid uidh ua att tsv dnt

namespace Dogma\Http;

use Dogma\InvalidRegularExpressionException;
use Dogma\InvalidValueException;
use function array_map;
use function explode;
use function implode;
use function preg_match;
use function strtolower;
use function ucfirst;

final readonly class HttpHeader
{

    public string $value;

    public function __construct(string $value)
    {
        if (!self::validateValue($value)) {
            throw new InvalidValueException($value, self::class);
        }

        $this->value = $value;
    }

    public static function from(string $value): self
    {
        return new self($value);
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    // IETF
    public const string ACCEPT = 'Accept';
    public const string ACCEPT_CHARSET = 'Accept-Charset';
    public const string ACCEPT_DATETIME = 'Accept-Datetime';
    public const string ACCEPT_ENCODING = 'Accept-Encoding';
    public const string ACCEPT_LANGUAGE = 'Accept-Language';
    public const string ACCEPT_PATCH = 'Accept-Patch';
    public const string ACCEPT_RANGES = 'Accept-Ranges';
    public const string ACCESS_CONTROL_ALLOW_ORIGIN = 'Access-Control-Allow-Origin';
    public const string AGE = 'Age';
    public const string ALLOW = 'Allow';
    public const string ALT_SVC = 'Alt-Svc';
    public const string AUTHORIZATION = 'Authorization';
    public const string CACHE_CONTROL = 'Cache-Control';
    public const string CONNECTION = 'Connection';
    public const string COOKIE = 'Cookie';
    public const string CONTENT_DISPOSITION = 'Content-Disposition';
    public const string CONTENT_ENCODING = 'Content-Encoding';
    public const string CONTENT_LANGUAGE = 'Content-Language';
    public const string CONTENT_LENGTH = 'Content-Length';
    public const string CONTENT_LOCATION = 'Content-Location';
    public const string CONTENT_MD5 = 'Content-MD5';
    public const string CONTENT_RANGE = 'Content-Range';
    public const string CONTENT_SECURITY_POLICY = 'Content-Security-Policy';
    public const string CONTENT_TYPE = 'Content-Type';
    public const string DATE = 'Date';
    public const string DNT = 'DNT';
    public const string EXPECT = 'Expect';
    public const string ET = 'ET';
    public const string ETAG = 'ETag';
    public const string EXPIRES = 'Expires';
    public const string FORWARDED = 'Forwarded';
    public const string FROM = 'From';
    public const string HOST = 'Host';
    public const string IF_MATCH = 'If-Match';
    public const string IF_MODIFIED_SINCE = 'If-Modified-Since';
    public const string IF_NONE_MATCH = 'If-None-Match';
    public const string IF_RANGE = 'If-Range';
    public const string IF_UNMODIFIED_SINCE = 'If-Unmodified-Since';
    public const string LAST_MODIFIED = 'Last-Modified';
    public const string LINK = 'Link';
    public const string LOCATION = 'Location';
    public const string MAX_FORWARDS = 'Max-Forwards';
    public const string ORIGIN = 'Origin';
    public const string P3P = 'P3P';
    public const string PRAGMA = 'Pragma';
    public const string PROXY_AUTHENTICATE = 'Proxy-Authenticate';
    public const string PROXY_AUTHORIZATION = 'Proxy-Authorization';
    public const string PUBLIC_KEY_PINS = 'Public-Key-Pins';
    public const string RANGE = 'Range';
    public const string REFERER = 'Referer';
    public const string REFRESH = 'Refresh';
    public const string RETRY_AFTER = 'Retry-After';
    public const string SAVE_DATA = 'Save-Data';
    public const string SERVER = 'Server';
    public const string SET_COOKIE = 'Set-Cookie';
    public const string STATUS = 'Status';
    public const string STRICT_TRANSPORT_SECURITY = 'Strict-Transport-Security';
    public const string TE = 'TE';
    public const string TRAILER = 'Trailer';
    public const string TRANSFER_ENCODING = 'Transfer-Encoding';
    public const string TSV = 'TSV';
    public const string USER_AGENT = 'User-Agent';
    public const string UPGRADE = 'Upgrade';
    public const string VARY = 'Vary';
    public const string VIA = 'Via';
    public const string WARNING = 'Warning';
    public const string WWW_AUTHENTICATE = 'WWW-Authenticate';
    public const string X_FRAME_OPTIONS = 'X-Frame-Options';

    // non-standard
    public const string CONTENT_CHARSET = 'Content-Charset';
    public const string FRONT_END_HTTPS = 'Front-End-Https';
    public const string HTTP_VERSION = 'Http-Version';
    public const string PROXY_CONNECTION = 'Proxy-Connection';
    public const string UPGRADE_INSECURE_REQUESTS = 'Upgrade-Insecure-Requests';
    public const string X_ATT_DEVICE_ID = 'X-ATT-DeviceId';
    public const string X_CONTENT_DURATION = 'X-Content-Duration';
    public const string X_CONTENT_SECURITY_POLICY = 'X-Content-Security-Policy';
    public const string X_CONTENT_TYPE_OPTIONS = 'X-Content-Type-Options';
    public const string X_CORRELATION_ID = 'X-Correlation-ID';
    public const string X_CSRF_TOKEN = 'X-Csrf-Token';
    public const string X_DO_NOT_TRACK = 'X-Do-Not-Track';
    public const string X_FORWARDED_FOR = 'X-Forwarded-For';
    public const string X_FORWARDED_HOST = 'X-Forwarded-Host';
    public const string X_FORWARDED_PROTO = 'X-Forwarded-Proto';
    public const string X_HTTP_METHOD_OVERRIDE = 'X-Http-Method-Override';
    public const string X_POWERED_BY = 'X-Powered-By';
    public const string X_REQUEST_ID = 'X-Request-ID';
    public const string X_REQUESTED_WITH = 'X-Requested-With';
    public const string X_UA_COMPATIBLE = 'X-UA-Compatible';
    public const string X_UIDH = 'X-UIDH';
    public const string X_XSS_PROTECTION = 'X-XSS-Protection';
    public const string X_WAP_PROFILE = 'X-Wap-Profile';
    public const string X_WEBKIT_CSP = 'X-WebKit-CSP';

    private const array EXCEPTIONS = [
        'et' => 'ET',
        'etag' => 'ETag',
        'te' => 'TE',
        'dnt' => 'DNT',
        'tsv' => 'TSV',
        'x-att-deviceid' => 'X-ATT-DeviceId',
        'x-correlation-id' => 'X-Correlation-ID',
        'x-request-id' => 'X-Request-ID',
        'x-ua-compatible' => 'X-UA-Compatible',
        'x-uidh' => 'X-UIDH',
        'x-xss-protection' => 'X-XSS-Protection',
        'x-webkit-csp' => 'X-WebKit-CSP',
        'www-authenticate' => 'WWW-Authenticate',
    ];

    public static function normalizeName(string $name): string
    {
        $name = strtolower($name);

        return self::EXCEPTIONS[$name]
            ?? implode('-', array_map(ucfirst(...), explode('-', $name)));
    }

    public static function validateValue(string &$value): bool
    {
        $value = self::normalizeName($value);

        $regexp = '/^' . self::getValueRegexp() . '?$/';
        $result = preg_match($regexp, $value);
        if ($result === false) {
            throw new InvalidRegularExpressionException($regexp);
        }

        return (bool) $result;
    }

    public static function getValueRegexp(): string
    {
        return '(?:X-)?[A-Z][a-z]+(?:[A-Z][a-z]+)*|' . implode('|', self::EXCEPTIONS);
    }

}
