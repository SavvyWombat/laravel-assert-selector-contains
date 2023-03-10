# Laravel AssertSelectorContains

[![Latest Version on Packagist](https://img.shields.io/packagist/v/savvywombat/laravel-assert-selector-contains.svg)](https://packagist.org/packages/savvywombat/laravel-assert-selector-contains)
![Supported PHP Version](https://img.shields.io/packagist/php-v/savvywombat/laravel-assert-selector-contains?style=flat-square)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
[![Build](https://img.shields.io/github/actions/workflow/status/SavvyWombat/laravel-assert-selector-contains/test.yml?branch=main)](https://github.com/SavvyWombat/laravel-assert-selector-contains/actions)
[![Code Coverage](https://codecov.io/gh/SavvyWombat/laravel-assert-selector-contains/branch/main/graph/badge.svg)](https://codecov.io/gh/SavvyWombat/laravel-assert-selector-contains)

Targeted content assertions using CSS selector expressions.

Laravel's built-in `assertSee` is useful, but has some limitations:

1. It makes a string match against the whole document, and could produce false positives.
2. It is hard to assert if specific items have been correctly set (page titles, input labels, etc)
3. When the assertion fails, it outputs the whole HTML document to the console.

This package provides a collection of additional assertions available on Laravel's `TestResponse` to help target specific elements/attributes and improve message on failure.

```
assertSelectorExists($selector)
assertSelectorDoesNotExist($selector)

assertSelectorContains($selector, $value)
assertSelectorDoesNotContain($selector, $value)

assertSelectorAttributeExists($selector, $attribute)
assertSelectorAttributeDoesNotExist($selector, $attribute)

assertSelectorAttributeEquals($selector, $attribute, $value)
assertSelectorAttributeDoesNotEqual($selector, $attribute, $value)

assertSelectorAttributeContains($selector, $attribute, $value)
assertSelectorAttributeDoesNotContain($selector, $attribute, $value)
```

So, if you want to make sure that you are correctly setting the document title:

`$response->assertSelectorContains('title', 'Welcome');`

If you want to assert that a label has been set for a specific form input:

`$response->assertSelectorExists('label[for=input-id]');`

Or if a specific input has been set with the correct initial value:

`$response->assertSelectorAttributeEquals('input[name=display_name]', 'value', 'SavvyWombat');`

## Installation

This package is available using [Composer](https://getcomposer.org/).

`composer require --dev savvywombat/laravel-assert-selector-contains`

## Usage

```php
namespace Tests\Feature;

use SavvyWombat\LaravelAssertSelectorContains\AssertsWithSelectors;
use Tests\TestCase;

class ExampleTest extends TestCase
{
  use AssertsWithSelectors;

  public function testDocumentTitleIsCorrect(): void
  {
    $response = $this->get('/');
    
    $response->assertSelectorContains('title', 'Welcome');
  }
}
```

## Credit

This package was inspired by a blog post from Liam Hammett:

[Laravel Testing CSS Selector Assertion Macros](https://liamhammett.com/laravel-testing-css-selector-assertion-macros-D9o0YAQJ)

## Support

Please report issues using the [GitHub issue tracker](https://github.com/SavvyWombat/LaravelAssertSelectorContains/issues). You are also welcome to fork the repository and submit a pull request.

## Licence

This package is licensed under [The MIT License (MIT)](https://github.com/SavvyWombat/LaravelAssertSelectorContains/blob/master/LICENSE).
