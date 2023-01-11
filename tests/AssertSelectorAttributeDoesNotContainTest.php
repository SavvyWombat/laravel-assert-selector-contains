<?php

namespace Tests;

use Orchestra\Testbench\Concerns\CreatesApplication;
use PHPUnit\Framework\AssertionFailedError;
use SavvyWombat\LaravelAssertSelectorContains\AssertsWithSelectors;

class AssertSelectorAttributeDoesNotContainTest extends TestCase
{
    use AssertsWithSelectors;
    use CreatesApplication;

    public function testAttributeSelectorDoesNotContainExpectedValue(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $response->assertSelectorAttributeDoesNotContain('input', 'name', 'unknownVal');
    }

    public function testSelectorNotFound(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("Selector 'nothing' missing from response.");

        $response->assertSelectorAttributeDoesNotContain('nothing', 'name', 'redValue');
    }

    public function testAttributeNotFound(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("Selector 'h1' missing attribute 'name'.");

        $response->assertSelectorAttributeDoesNotContain('h1', 'name', 'redValue');
    }

    public function testAttributeContainsExpectedValue(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Selector 'input' found with attribute 'name' containing 'redValue'."
        );

        $response->assertSelectorAttributeDoesNotContain('input', 'name', 'redValue');
    }
}
