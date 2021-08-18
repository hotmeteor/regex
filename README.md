# Regex

A set of ready-made regex helper methods for use in your Laravel application.

[![Latest Stable Version](http://poser.pugx.org/hotmeteor/regex/v)](https://packagist.org/packages/hotmeteor/regex)

## Installation

```shell
composer require hotmeteor/regex
```

## Usage

Regex comes with a set of common regex patterns that are ready to use. These patterns can be used to either **replace** or **match** against values. Every pattern is both case-insensitive and able to interpret unicode characters, and should support all languages.

Additionally, beyond the methods below both the underlying `match` and `replace` methods are exposed to pass in custom patterns.

### Match

Match methods return true or false depending on if the subject value contains anything but the expected pattern. 

You may optional allow whitespace by passing `true` as a second parameter.

#### Methods

```php
Regex::isAlpha($subject, $allowWhitespace = false)
``` 
Checks if the value contains anything but letters.

***

```php
Regex::isAlphanumeric($subject, $allowWhitespace = false)
``` 
Checks if the value contains anything but letters and numbers.

***

```php
Regex::isAlphadash($subject, $allowWhitespace = false)
``` 
Checks if the value contains anything but letters, numbers, and `.-_`.

***

```php
Regex::isDigits($subject, $allowWhitespace = false)
``` 
Checks if the value contains anything but integers.

***

```php
Regex::isNumeric($subject)
``` 
Checks if the value contains anything but numeric values, including decimals and negative numbers. Does not allow for whitespace.

***

```php
Regex::isUuid($subject)
``` 
Checks if the value is a UUID. Does not allow for whitespace.

### Replace

Replace methods replace anything in the subject value that doesn't match the pattern with the provided replacement.

The default replacement is nothing: it just removes the character.

#### Methods
```php
Regex::alpha($subject, $replace = '')
``` 
Replaces all characters in the subject except letters.

***

```php
Regex::alphanumeric($subject, $replace = '')
``` 
Replaces all characters in the subject except letters and numbers.

***

```php
Regex::alphadash($subject, $replace = '')
``` 
Replaces all characters in the subject except letters, numbers, and `.-_`.

***

```php
Regex::digits($subject, $replace = '')
``` 
Replaces all characters in the subject except integers.

***

```php
Regex::numeric($subject, $replace = '')
``` 
Replaces all characters in the subject except numeric values, including decimals and negative numbers.
 
***

```php
Regex::uuid($subject)
``` 
Replaces all characters in the subject to form it into a UUID. Does not accept a replacement value.
 