# Regex

A set of ready-made regex helper methods for use in your Laravel application.

[![Latest Version on Packagist](https://img.shields.io/packagist/vpre/hotmeteor/regex.svg?style=flat-square)](https://packagist.org/packages/hotmeteor/regex)
![PHP from Packagist](https://img.shields.io/packagist/php-v/hotmeteor/regex)

## Installation

```shell
composer require hotmeteor/regex
```

## Usage

Regex comes with a set of common regex patterns that are ready to use. These patterns can be used to either **replace** or **match** against values. Every pattern is both case-insensitive and able to interpret unicode characters, and should support all languages.

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
Regex::isInteger($subject, $allowWhitespace = false)
``` 
Checks if the value contains anything but integers.

***

```php
Regex::isNumeric($subject)
``` 
Checks if the value contains anything but numeric values, including decimals and negative numbers. Does not allow for whitespace.


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
Regex::integer($subject, $replace = '')
``` 
Replaces all characters in the subject except integers.

***

```php
Regex::numeric($subject, $replace = '')
``` 
Replaces all characters in the subject except numeric values, including decimals and negative numbers.
 
