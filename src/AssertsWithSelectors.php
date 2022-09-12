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
        /**
         * @see https://liamhammett.com/laravel-testing-css-selector-assertion-macros-D9o0YAQJ
         */
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
        TestResponse::macro('assertSelectorContains', function (string $selector, string $value): TestResponse {
            $selectorContents = $this->getSelectorContents($selector);

            if ($selectorContents->length === 0) {
                PHPUnit::fail("The selector '{$selector}' was not found in the response.");

                return $this;
            }

            foreach ($selectorContents as $element) {
                if (Str::contains($element->textContent, $value)) {
                    PHPUnit::assertTrue(true);

                    return $this;
                }
            }

            PHPUnit::fail("The selector '{$selector}' did not contain the value '{$value}'.");
        });
    }
}