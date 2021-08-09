<?php

namespace Tests;

use Hotmeteor\Regex\Regex;

class RegexTest extends TestCase
{
    /**
     * @dataProvider providesReplacementSubjects
     */
    public function test_replacements(
        $method,
        $expected
    ) {
        $result = Regex::{$method}('AbČdë 12345 .-_!*{}');

        $this->assertSame($expected, $result);
    }

    public function providesReplacementSubjects()
    {
        return [

            'replace non alpha' => [
                'alpha',
                'AbČdë',
            ],

            'replace non alphanumeric' => [
                'alphanumeric',
                'AbČdë12345',
            ],

            'replace non alphadash' => [
                'alphadash',
                'AbČdë12345.-_',
            ],

            'replace non digits' => [
                'digits',
                '12345',
            ],

            'replace non numeric' => [
                'numeric',
                '12345.-*',
            ],

        ];
    }

    /**
     * @dataProvider providesMatchSubjects
     */
    public function test_matches(
        $method,
        $subject,
        $allowWhitespace,
        $expected
    ) {
        $result = Regex::{$method}($subject, $allowWhitespace);

        $this->assertSame($expected, $result);
    }

    public function providesMatchSubjects()
    {
        $allowWhitespace = true;
        $disallowWhitespace = false;

        $valid = true;
        $invalid = false;

        return [

            'match alpha' => [
                'isAlpha',
                'AbČdë',
                $disallowWhitespace,
                $valid,
            ],

            'match alpha allow whitespace' => [
                'isAlpha',
                'AbČd ë',
                $allowWhitespace,
                $valid,
            ],

            'match alpha disallow whitespace' => [
                'isAlpha',
                'AbČd ë',
                $disallowWhitespace,
                $invalid,
            ],

            'match non alpha' => [
                'isAlpha',
                'AbČdë2.',
                $disallowWhitespace,
                $invalid,
            ],

            'match alphadash' => [
                'isAlphadash',
                'AbČdë2_-',
                $disallowWhitespace,
                $valid,
            ],

            'match alphadash allow whitespace' => [
                'isAlphadash',
                'AbČd ë2_-',
                $allowWhitespace,
                $valid,
            ],

            'match alphadash disallow whitespace' => [
                'isAlphadash',
                'AbČd ë2_-',
                $disallowWhitespace,
                $invalid,
            ],

            'match non alphadash' => [
                'isAlphadash',
                'AbČdë2_-!',
                $disallowWhitespace,
                $invalid,
            ],

            'match alphanumeric' => [
                'isAlphanumeric',
                'AbČdë2',
                $disallowWhitespace,
                $valid,
            ],

            'match alphanumeric allow whitespace' => [
                'isAlphanumeric',
                'AbČdë 2',
                $allowWhitespace,
                $valid,
            ],

            'match alphanumeric disallow whitespace' => [
                'isAlphanumeric',
                'AbČdë 2',
                $disallowWhitespace,
                $invalid,
            ],

            'match non alphanumeric' => [
                'isAlphanumeric',
                'AbČdë2-',
                $disallowWhitespace,
                $invalid,
            ],

            'match digits' => [
                'isDigits',
                '12345',
                $disallowWhitespace,
                $valid,
            ],

            'match digits allow whitespace' => [
                'isDigits',
                '1234 5',
                $allowWhitespace,
                $valid,
            ],

            'match digits disallow whitespace' => [
                'isDigits',
                '1234 5',
                $disallowWhitespace,
                $invalid,
            ],

            'match non digits' => [
                'isDigits',
                '12345A',
                $disallowWhitespace,
                $invalid,
            ],

            'match numeric' => [
                'isNumeric',
                '-11.3456',
                $disallowWhitespace,
                $valid,
            ],

            'match non numeric' => [
                'isNumeric',
                '10^4',
                $disallowWhitespace,
                $invalid,
            ],

        ];
    }
}
