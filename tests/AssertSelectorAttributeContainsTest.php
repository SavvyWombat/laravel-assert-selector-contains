<?php

namespace Tests;

use Orchestra\Testbench\Concerns\CreatesApplication;
use PHPUnit\Framework\AssertionFailedError;
use SavvyWombat\LaravelAssertSelectorContains\AssertsWithSelectors;

class AssertSelectorAttributeContainsTest extends TestCase
{
    use AssertsWithSelectors;
    use CreatesApplication;

    public function testAttributeSelectorContainsExpectedValue(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $response->assertSelectorAttributeContains('input', 'name', 'redVal');
    }

    public function testSelectorNotFound(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("Selector 'nothing' missing from response.");

        $response->assertSelectorAttributeContains('nothing', 'name', 'requiredValue');
    }

    public function testAttributeNotFound(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("Selector 'h1' missing attribute 'name'.");

        $response->assertSelectorAttributeContains('h1', 'name', 'unknownValue');
    }

    public function testAttributeDoesNotContainExpectedValue(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Attribute 'name' on selector 'input' does not contain the expected value 'unknownValue'."
        );

        $response->assertSelectorAttributeContains('input', 'name', 'unknownValue');
    }
}
