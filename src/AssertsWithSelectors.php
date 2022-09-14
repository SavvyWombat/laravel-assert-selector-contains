<?php

namespace SavvyWombat\LaravelAssertSelectorContains;

use DOMXPath;
use DOMDocument;
use DOMNodeList;
use Illuminate\Support\Str;
use Illuminate\Testing\Assert as PHPUnit;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Component\CssSelector\CssSelectorConverter;

trait AssertsWithSelectors
{
    public function setupAssertsWithSelectors(): void
    {
        TestResponse::macro('getSelectorContents', function (string $selector): DOMNodeList {
            $dom = new DOMDocument();

            @$dom->loadHTML(
                mb_convert_encoding($this->getContent(), 'HTML-ENTITIES', 'UTF-8'),
                LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
            );

            $converter = new CssSelectorConverter();
            $xpathSelector = $converter->toXPath($selector);

            $xpath = new DOMXPath($dom);
            $elements = $xpath->query($xpathSelector);

            return $elements;
        });

        /**
         * @throws AssertionFailedError
         */
        TestResponse::macro('assertSelectorExists', function (string $selector): TestResponse {
            $selectorContents = $this->getSelectorContents($selector);

            if ($selectorContents->length === 0) {
                PHPUnit::fail("Selector '{$selector}' missing from response.");
            }

            PHPUnit::assertTrue(true);

            return $this;

        });

        /**
         * @throws AssertionFailedError
         */
        TestResponse::macro('assertSelectorDoesNotExist', function (string $selector): TestResponse {
            $selectorContents = $this->getSelectorContents($selector);

            if ($selectorContents->length === 0) {
                PHPUnit::assertTrue(true);

                return $this;
            }

            PHPUnit::fail("Selector '{$selector}' found in response.");
        });

        /**
         * @throws AssertionFailedError
         */
        TestResponse::macro('assertSelectorContains', function (string $selector, string $value): TestResponse {
            $selectorContents = $this->getSelectorContents($selector);

            if ($selectorContents->length === 0) {
                PHPUnit::fail("Selector '{$selector}' missing from response.");
            }

            foreach ($selectorContents as $element) {
                if (Str::contains($element->textContent, $value)) {
                    PHPUnit::assertTrue(true);

                    return $this;
                }
            }

            PHPUnit::fail("Selector '{$selector}' does not contain '{$value}'.");
        });

        /**
         * @throws AssertionFailedError
         */
        TestResponse::macro('assertSelectorDoesNotContain', function (string $selector, string $value): TestResponse {
            $selectorContents = $this->getSelectorContents($selector);

            if ($selectorContents->length === 0) {
                PHPUnit::fail("Selector '{$selector}' missing from response.");
            }

            foreach ($selectorContents as $element) {
                if (Str::contains($element->textContent, $value)) {
                    PHPUnit::fail("Selector '{$selector}' found with content '${value}'.");
                }
            }

            PHPUnit::assertTrue(true);

            return $this;
        });

        /**
         * @throws AssertionFailedError
         */
        TestResponse::macro('assertSelectorAttributeExists', function (string $selector, string $attribute): TestResponse {
            $selectorContents = $this->getSelectorContents($selector);

            if ($selectorContents->length === 0) {
                PHPUnit::fail("Selector '{$selector}' missing from response.");
            }

            foreach ($selectorContents as $element) {
                if ($element->hasAttribute($attribute)) {
                    PHPUnit::assertTrue(true);

                    return $this;
                }
            }

            PHPUnit::fail("Selector '{$selector}' missing attribute '{$attribute}'.");
        });

        /**
         * @throws AssertionFailedError
         */
        TestResponse::macro('assertSelectorAttributeDoesNotExist', function (string $selector, string $attribute): TestResponse {
            $selectorContents = $this->getSelectorContents($selector);

            if ($selectorContents->length === 0) {
                PHPUnit::fail("Selector '{$selector}' missing from response.");
            }

            foreach ($selectorContents as $element) {
                if ($element->hasAttribute($attribute)) {
                    PHPUnit::fail("Selector '{$selector}' found with attribute '{$attribute}'.");
                }
            }

            PHPUnit::assertTrue(true);

            return $this;
        });

        /**
         * @throws AssertionFailedError
         */
        TestResponse::macro('assertSelectorAttributeEquals', function (string $selector, string $attribute, string $value): TestResponse {
            $this->assertSelectorAttributeExists($selector, $attribute);

            $selectorContents = $this->getSelectorContents($selector);

            if ($selectorContents->length === 0) {
                PHPUnit::fail("Selector '{$selector}' missing from response.");
            }

            foreach ($selectorContents as $element) {
                if ($element->getAttribute($attribute) === $value) {
                    PHPUnit::assertTrue(true);

                    return $this;
                }
            }

            PHPUnit::fail("Attribute '{$attribute}' on selector '{$selector}' does not have the expected value '{$value}'.");
        });

        /**
         * @throws AssertionFailedError
         */
        TestResponse::macro('assertSelectorAttributeDoesNotEqual', function (string $selector, string $attribute, string $value): TestResponse {
            $this->assertSelectorAttributeExists($selector, $attribute);

            $selectorContents = $this->getSelectorContents($selector);

            foreach ($selectorContents as $element) {
                if ($element->getAttribute($attribute) === $value) {
                    PHPUnit::fail("Selector '{$selector}' found with attribute '{$attribute}' set to value '{$value}'.");
                }
            }

            PHPUnit::assertTrue(true);

            return $this;
        });
    }
}
