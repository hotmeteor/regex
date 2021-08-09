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
    public static function alpha($subject, $replace = '')
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
    public static function alphadash($subject, $replace = '')
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
    public static function alphanumeric($subject, $replace = '')
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
    public static function digits($subject, $replace = '')
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
    public static function numeric($subject, $replace = '')
    {
        return static::replace($subject, self::PATTERN_NUMERIC, $replace);
    }

    /**
     * @param $subject
     * @param $pattern
     * @param  string  $replacement
     * @return array|string|string[]|null
     */
    public static function replace($subject, $pattern, $replacement = '')
    {
        return preg_replace(self::wrapReplacePattern($pattern), $replacement, $subject);
    }

    /**
     * Check if it's only alpha-dash.
     *
     * @param $subject
     * @param  bool  $allowWhitespace
     * @return bool
     */
    public static function isAlpha($subject, bool $allowWhitespace = false)
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
    public static function isAlphadash($subject, bool $allowWhitespace = false)
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
    public static function isAlphanumeric($subject, bool $allowWhitespace = false)
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
    public static function isDigits($subject, bool $allowWhitespace = false)
    {
        return static::match($subject, self::PATTERN_DIGITS, $allowWhitespace);
    }

    /**
     * Check if it's only numeric.
     *
     * @param $subject
     * @param  bool  $allowWhitespace
     * @return bool
     */
    public static function isNumeric($subject, bool $allowWhitespace = false)
    {
        return static::match($subject, self::PATTERN_NUMERIC);
    }

    /**
     * @param $subject
     * @param $pattern
     * @param  bool  $allowWhitespace
     * @return bool
     */
    public static function match($subject, $pattern, bool $allowWhitespace = false): bool
    {
        $result = preg_match(self::wrapMatchPattern($pattern, $allowWhitespace), $subject);

        return is_numeric($result) ? $result === 1 : $result;
    }

    /**
     * Wrap a replace pattern with boundaries.
     *
     * @param $pattern
     * @return string
     */
    protected static function wrapReplacePattern($pattern): string
    {
        return implode('', ['/[^', $pattern, ']+/u']);
    }

    /**
     * Wrap a match pattern with boundaries.
     *
     * @param $pattern
     * @param  bool  $allowWhitespace
     * @return string
     */
    protected static function wrapMatchPattern($pattern, bool $allowWhitespace = false): string
    {
        return implode('', ['/^[', $allowWhitespace ? '\s' : '', $pattern, ']+$/u']);
    }
}
