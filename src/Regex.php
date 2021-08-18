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
    const PATTERN_UUID = '\da-f]{8}-[\da-f]{4}-[\da-f]{4}-[\da-f]{4}-[\da-f]{12}';

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
     * @param $subject
     * @param $pattern
     * @param  string  $replace
     * @return array|string|string[]|null
     */
    public static function replace($subject, $pattern, string $replace = '', $prefix = '/[^', $suffix = ']+/u')
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
     * @param $subject
     * @param $pattern
     * @param  bool  $allowWhitespace
     * @return bool
     */
    public static function match($subject, $pattern, bool $allowWhitespace = false, $prefix = '/^[', $suffix = ']+$/u'): bool
    {
        $result = preg_match(self::wrapMatchPattern($pattern, $allowWhitespace, $prefix, $suffix), $subject);

        return is_numeric($result) ? $result === 1 : $result;
    }

    /**
     * Wrap a replace pattern with boundaries.
     *
     * @param $pattern
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
     * @return string
     */
    protected static function wrapMatchPattern($pattern, bool $allowWhitespace, $prefix, $suffix): string
    {
        return implode('', [$prefix, $allowWhitespace ? '\s' : '', $pattern, $suffix]);
    }
}
