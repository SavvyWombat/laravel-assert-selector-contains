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
        $this->expectExceptionMessage("The selector 'nothing' was not found in the response.");

        $response->assertSelectorAttributeEquals('nothing', 'name', 'requiredValue');
    }

    public function testAttributeNotFound(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The selector 'h1' does not have the attribute 'name'.");

        $response->assertSelectorAttributeEquals('h1', 'name', 'unknownValue');
    }

    public function testAttributeDoesNotMatchExpectedValue(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The attribute 'name' on the selector 'input' does not have the expected value 'unknownValue'.");

        $response->assertSelectorAttributeEquals('input', 'name', 'unknownValue');
    }
}
