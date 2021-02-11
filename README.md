# PHP Value Object

Just another library to handle Value Objects and prevent the bad habit of Primitive Obsession

[![Latest Version](https://img.shields.io/github/release/DavidGarciaCat/php-value-object.svg?style=flat-square)](https://github.com/DavidGarciaCat/php-value-object/releases)
[![Build Status](https://img.shields.io/scrutinizer/build/g/DavidGarciaCat/php-value-object.svg?style=flat-square)](https://scrutinizer-ci.com/g/DavidGarciaCat/php-value-object)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/DavidGarciaCat/php-value-object.svg?style=flat-square)](https://scrutinizer-ci.com/g/DavidGarciaCat/php-value-object)
[![Quality Score](https://img.shields.io/scrutinizer/g/DavidGarciaCat/php-value-object.svg?style=flat-square)](https://scrutinizer-ci.com/g/DavidGarciaCat/php-value-object)
[![Total Downloads](https://img.shields.io/packagist/dt/DavidGarciaCat/php-value-object.svg?style=flat-square)](https://packagist.org/packages/DavidGarciaCat/php-value-object)

## Changelog

All notable changes to this project will be documented in [this ChangeLog file](CHANGELOG.md).

## Install

Require the vendor with Composer:

```shell
composer require david-garcia/value-object
```

## Usage

Make sure you are loading the Composer autoload:

```php
require 'vendor/autoload.php';
```

Don't forget adding the use statement for each one of the value objects you need to use:

```php
// Example for StringValue
use DavidGarcia\ValueObject\Primitive\StringValue;
```

All value objects have a static `create()` method:

```php
StringValue::create('qwerty');
```

The first argument is the value to be wrapped by the value object. The second argument allows you to `statically cache` the value object, so you can instantiate twice an object with the same value but the system will create it just once:

```php
$stringValue1 = StringValue::create('qwerty', true);
$stringValue2 = StringValue::create('qwerty', true);

if ($stringValue1 === $stringValue2) {
    // TRUE
    // It's the same object, so it goes inside this conditional
}

$stringValue3 = StringValue::create('qwerty');
$stringValue4 = StringValue::create('qwerty');

if ($stringValue3 === $stringValue4) {
    // FALSE
    // Although they have the same value, the system has created two different objects
}
```

Null values always hold a `null` value:

```php
// `NullValue` does not expect any argument
$nullValue = NullValue::create();
```

All value objects have a `getValue()` method to expose the value:

```php
$stringValue = StringValue::create('qwerty');
$stringValue->getValue(); // Returns 'qwerty'
```

The `StringValue` value object and any other that extends from this one can use the `__toString` magic method to return the string value, as an alternative to the `getValue()` method:

```php
$stringValue = StringValue::create('qwerty');
(string) $stringValue; // Returns 'qwerty'
```

All value objects (except `NullValue`) have an `equals()` method that compares the content of two value objects of the same type:

```php
$stringValue1 = StringValue::create('qwerty', true);
$stringValue2 = StringValue::create('qwerty', true);

if ($stringValue1->equals($stringValue2)) {
    // TRUE
    // We ignore the fact that is a cached object, as we compare the value
}

$stringValue3 = StringValue::create('qwerty');
$stringValue4 = StringValue::create('qwerty');

if ($stringValue3->equals($stringValue4)) {
    // TRUE
    // We have a match for the values, so even if we handle two different objects,
    // their values are equal
}
```
