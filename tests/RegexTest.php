<?php

namespace Tests;

use Hotmeteor\Regex\Regex;
use PHPUnit\Framework\Attributes\DataProvider;

class RegexTest extends TestCase
{
    #[DataProvider('providesReplacementSubjects')]
    public function test_replacements(
        $method,
        $expected
    ) {
        $result = Regex::{$method}('AbČdë 12345 .-_!*{}');

        $this->assertSame($expected, $result);
    }

    public static function providesReplacementSubjects()
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

    public function test_uuid_replace()
    {
        $expected = '440526d4-04bd-43c4-9ac5-55e15c835d0d';

        $result = Regex::uuid('440526d4-04bd-43c4-9ac5-55e15c835d0d');

        $this->assertSame($expected, $result);

        $result = Regex::uuid('4405  26d4-04bd43c4-9ac5 - 55e15c  835d0d ');

        $this->assertSame($expected, $result);
    }

    public function test_ipv4_replace()
    {
        $examples = [
            '192.168.1.1' => '192.168.1.1',
            '192. 168. 1. 1' => '192.168.1.1',
            'ip address: 192.168.1.1' => '192.168.1.1',
            'ip address: 19216811' => '192.168.1.1',
            '255.255.255.255' => '255.255.255.255',
            '2 55 255.25 5255 ' => '255.255.255.255',
        ];

        foreach ($examples as $ip => $expected) {
            $result = Regex::ipv4($ip);

            $this->assertSame($expected, $result);
        }
    }

    public function test_ipv6_replace()
    {
        $examples = [
            '2001:0db8:85a3:0000:0000:8a2e:0370:7334' => '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
            '20 01:  0db8:85a3 : 0000:0 000:8a2e:0 370:7334 ' => '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
            'FE80:0000:0000 0000:0202:B3FF:FE1E:8329' => 'FE80:0000:0000:0000:0202:B3FF:FE1E:8329',
            'F E80:0000:0 000:0 000:020  2:B3 FF FE1E: 8329' => 'FE80:0000:0000:0000:0202:B3FF:FE1E:8329',
            'FE80::8329' => 'FE80::8329',
            'FE80::FFFF:8329' => 'FE80::FFFF:8329',
            'FE80::B3FF:FFFF:8329' => 'FE80::B3FF:FFFF:8329',
            'FE80::0202:B3FF:FFFF:8329' => 'FE80::0202:B3FF:FFFF:8329',
            'FE80::0000:0202:B3FF:FFFF:8329' => 'FE80::0000:0202:B3FF:FFFF:8329',
            'FE80::0000:0000:0202:B3FF:FFFF:8329' => 'FE80::0000:0000:0202:B3FF:FFFF:8329',
            'FE80:0000:0000:0000:0202:B3FF:FFFF:8329' => 'FE80:0000:0000:0000:0202:B3FF:FFFF:8329',
        ];

        foreach ($examples as $ip => $expected) {
            $result = Regex::ipv6($ip);

            $this->assertSame($expected, $result);
        }
    }

    #[DataProvider('providesMatchSubjects')]
    public function test_matches(
        $method,
        $subject,
        $allowWhitespace,
        $expected
    ) {
        $result = Regex::{$method}($subject, $allowWhitespace);

        $this->assertSame($expected, $result);
    }

    public static function providesMatchSubjects()
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

    public function test_uuid_match()
    {
        $expected = '440526d4-04bd-43c4-9ac5-55e15c835d0d';

        $result = Regex::isUuid('440526d4-04bd-43c4-9ac5-55e15c835d0d');

        $this->assertTrue($result);

        $result = Regex::isUuid('4405  26d4-04bd43c4-9ac5 - 55e15c  835d0d ');

        $this->assertFalse($result);
    }

    public function test_ipv4_match()
    {
        $examples = [
            '192.168.1.1' => true,
            '127.0.0.1' => true,
            '0.0.0.0' => true,
            '255.255.255.255' => true,
            '256.256.256.256' => false,
            '999.999.999.999' => false,
            '1.2.3' => false,
            '1.2.3.4' => true,
        ];

        foreach ($examples as $ip => $expected) {
            $ipResult = Regex::isIp($ip);
            $ipv4Result = Regex::isIpv4($ip);

            $this->assertSame($expected, $ipResult);
            $this->assertSame($expected, $ipv4Result);
        }
    }

    public function test_ipv6_match()
    {
        $examples = [
            '2001:0db8:85a3:0000:0000:8a2e:0370:7334' => true,
            'FE80:0000:0000:0000:0202:B3FF:FE1E:8329' => true,
            '192.168.1.1' => false,
            'test:test:test:test:test:test:test:test' => false,
        ];

        foreach ($examples as $ip => $expected) {
            $result = Regex::isIpv6($ip);

            $this->assertSame($expected, $result);
        }
    }
}
