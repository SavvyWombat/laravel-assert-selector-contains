<?php

namespace Tests;

use Orchestra\Testbench\Concerns\CreatesApplication;
use PHPUnit\Framework\AssertionFailedError;
use SavvyWombat\LaravelAssertSelectorContains\AssertsWithSelectors;

class AssertSelectorAttributeEqualsTest extends TestCase
{
    use AssertsWithSelectors;
    use CreatesApplication;

    public function testAttributeEqualsExpectedValue(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $response->assertSelectorAttributeEquals('input', 'name', 'requiredValue');
    }

    public function testSelectorNotFound(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("Selector 'nothing' missing from response.");

        $response->assertSelectorAttributeEquals('nothing', 'name', 'requiredValue');
    }

    public function testAttributeNotFound(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("Selector 'h1' missing attribute 'name'.");

        $response->assertSelectorAttributeEquals('h1', 'name', 'unknownValue');
    }

    public function testAttributeDoesNotMatchExpectedValue(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Attribute 'name' on selector 'input' does not have the expected value 'unknownValue'."
        );

        $response->assertSelectorAttributeEquals('input', 'name', 'unknownValue');
    }
}
