<?php

namespace Hotmeteor\Regex;

use Illuminate\Support\Traits\Macroable;

class Regex
{
    use Macroable;

    const PATTERN_ALPHA = '\pL\pM';
    const PATTERN_ALPHANUMERIC = '\pL\pM\pN';
    const PATTERN_ALPHADASH = '\pL\pM\pN._-';
    const PATTERN_DIGITS = '0-9';
    const PATTERN_NUMERIC = '-?\d*(\.\d+)?';

    /**
     * Filter to only alpha.
     *
     * @param $subject
     * @param  string  $replace
     * @return array|string|string[]|null
     */
    public static function alpha($subject, string $replace = '')
    {
        return static::replace($subject, self::PATTERN_ALPHA, $replace);
    }

    /**
     * Filter to only alpha-dash.
     *
     * @param $subject
     * @param  string  $replace
     * @return array|string|string[]|null
     */
    public static function alphadash($subject, string $replace = '')
    {
        return static::replace($subject, self::PATTERN_ALPHADASH, $replace);
    }

    /**
     * Filter to only alphanumeric.
     *
     * @param $subject
     * @param  string  $replace
     * @return array|string|string[]|null
     */
    public static function alphanumeric($subject, string $replace = '')
    {
        return static::replace($subject, self::PATTERN_ALPHANUMERIC, $replace);
    }

    /**
     * Filter to only integers.
     *
     * @param $subject
     * @param  string  $replace
     * @return array|string|string[]|null
     */
    public static function digits($subject, string $replace = '')
    {
        return static::replace($subject, self::PATTERN_DIGITS, $replace);
    }

    /**
     * Filter to only numeric.
     *
     * @param $subject
     * @param  string  $replace
     * @return array|string|string[]|null
     */
    public static function numeric($subject, string $replace = '')
    {
        return static::replace($subject, self::PATTERN_NUMERIC, $replace);
    }

    /**
     * Filter to only UUID format.
     *
     * @param $subject
     * @return array|string|string[]|null
     */
    public static function uuid($subject)
    {
        $subject = static::alphanumeric($subject);

        return preg_replace("/(\w{8})(\w{4})(\w{4})(\w{4})(\w{12})/i", '$1-$2-$3-$4-$5', $subject);
    }

    /**
     * Filter to only IPv4 format.
     *
     * @param $subject
     * @return string
     */
    public static function ip($subject): string
    {
        return static::ipv4($subject);
    }

    /**
     * Filter to only IPv4 format.
     *
     * @param $subject
     * @return string
     */
    public static function ipv4($subject): string
    {
        $subject = static::digits($subject);

        $pattern = str_repeat('(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]|[0|1])', 4);

        return static::glue($subject, $pattern, '.');
    }

    /**
     * Filter to only IPv6 format.
     *
     * @param $subject
     * @return string
     */
    public static function ipv6($subject): string
    {
        $subject = str_replace(' ', '', static::alphanumeric($subject));

        $count = floor(strlen($subject) / 4);

        $pattern = str_repeat('([0-9a-fA-F]{1,4})', $count);

        preg_match(self::wrapMatchPattern($pattern, false, '/', '/'), $subject, $matches);

        // Get rid of full subject.
        array_shift($matches);

        $prefix = null;

        if ($count < 8) {
            $prefix = implode('::', array_slice($matches, 0, 2));
            $matches = array_slice($matches, 2);
        }

        $matches = implode(':', $matches);

        return implode(':', array_filter([$prefix, $matches]));
    }

    /**
     * @param $subject
     * @param $pattern
     * @param  string  $replace
     * @param  string  $prefix
     * @param  string  $suffix
     * @return array|string|string[]|null
     */
    public static function replace($subject, $pattern, string $replace = '', string $prefix = '/[^', string $suffix = ']+/u')
    {
        return preg_replace(self::wrapReplacePattern($pattern, $prefix, $suffix), $replace, $subject);
    }

    /**
     * Check if it's only alpha-dash.
     *
     * @param $subject
     * @param  bool  $allowWhitespace
     * @return bool
     */
    public static function isAlpha($subject, bool $allowWhitespace = false): bool
    {
        return static::match($subject, self::PATTERN_ALPHA, $allowWhitespace);
    }

    /**
     * Check if it's only alpha-dash.
     *
     * @param $subject
     * @param  bool  $allowWhitespace
     * @return bool
     */
    public static function isAlphadash($subject, bool $allowWhitespace = false): bool
    {
        return static::match($subject, self::PATTERN_ALPHADASH, $allowWhitespace);
    }

    /**
     * Check if it's only alphanumeric.
     *
     * @param $subject
     * @param  bool  $allowWhitespace
     * @return bool
     */
    public static function isAlphanumeric($subject, bool $allowWhitespace = false): bool
    {
        return static::match($subject, self::PATTERN_ALPHANUMERIC, $allowWhitespace);
    }

    /**
     * Check if it's only numeric.
     *
     * @param $subject
     * @param  bool  $allowWhitespace
     * @return bool
     */
    public static function isDigits($subject, bool $allowWhitespace = false): bool
    {
        return static::match($subject, self::PATTERN_DIGITS, $allowWhitespace);
    }

    /**
     * Check if it's only numeric.
     *
     * @param $subject
     * @return bool
     */
    public static function isNumeric($subject): bool
    {
        return static::match($subject, self::PATTERN_NUMERIC);
    }

    /**
     * Check if it's only numeric.
     *
     * @param $subject
     * @return bool
     */
    public static function isUuid($subject): bool
    {
        return static::match($subject, '/^[\da-f]{8}-[\da-f]{4}-[\da-f]{4}-[\da-f]{4}-[\da-f]{12}$/iD', false, '', '');
    }

    /**
     * Check if it's an IPv4 address.
     *
     * @param $subject
     * @return bool
     */
    public static function isIp($subject): bool
    {
        return static::isIpv4($subject);
    }

    /**
     * Check if it's an IPv4 address.
     *
     * @param $subject
     * @return bool
     */
    public static function isIpv4($subject): bool
    {
        return static::match($subject, '/^((2[0-4]|1\d|[1-9])?\d|25[0-5])(\.(?1)){3}\z/', false, '', '');
    }

    /**
     * Check if it's an IPv6 address.
     *
     * @param $subject
     * @return bool
     */
    public static function isIpv6($subject): bool
    {
        return static::match($subject, '/^(((?=(?>.*?(::))(?!.+\3)))\3?|([\dA-F]{1,4}(\3|:(?!$)|$)|\2))(?4){5}((?4){2}|((2[0-4]|1\d|[1-9])?\d|25[0-5])(\.(?7)){3})\z/i', false, '', '');
    }

    /**
     * @param $subject
     * @param $pattern
     * @param  bool  $allowWhitespace
     * @param  string  $prefix
     * @param  string  $suffix
     * @return bool
     */
    public static function match($subject, $pattern, bool $allowWhitespace = false, string $prefix = '/^[', string $suffix = ']+$/u'): bool
    {
        $result = preg_match(self::wrapMatchPattern($pattern, $allowWhitespace, $prefix, $suffix), $subject);

        return is_numeric($result) ? $result === 1 : $result;
    }

    /**
     * @param $subject
     * @param $pattern
     * @param  string  $glue
     * @param  bool  $allowWhitespace
     * @param  string  $prefix
     * @param  string  $suffix
     * @return string
     */
    public static function glue($subject, $pattern, string $glue = '', bool $allowWhitespace = false, string $prefix = '/', string $suffix = '/'): string
    {
        preg_match(self::wrapMatchPattern($pattern, $allowWhitespace, $prefix, $suffix), $subject, $matches);

        array_shift($matches);

        return implode($glue, $matches);
    }

    /**
     * Wrap a replace pattern with boundaries.
     *
     * @param $pattern
     * @param $prefix
     * @param $suffix
     * @return string
     */
    protected static function wrapReplacePattern($pattern, $prefix, $suffix): string
    {
        return implode('', [$prefix, $pattern, $suffix]);
    }

    /**
     * Wrap a match pattern with boundaries.
     *
     * @param $pattern
     * @param  bool  $allowWhitespace
     * @param $prefix
     * @param $suffix
     * @return string
     */
    protected static function wrapMatchPattern($pattern, bool $allowWhitespace, $prefix, $suffix): string
    {
        return implode('', [$prefix, $allowWhitespace ? '\s' : '', $pattern, $suffix]);
    }
}
