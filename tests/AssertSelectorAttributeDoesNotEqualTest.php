<?php

namespace Tests;

use Orchestra\Testbench\Concerns\CreatesApplication;
use PHPUnit\Framework\AssertionFailedError;
use SavvyWombat\LaravelAssertSelectorContains\AssertsWithSelectors;

class AssertSelectorAttributeDoesNotEqualTest extends TestCase
{
    use AssertsWithSelectors;
    use CreatesApplication;

    public function testAttributeDoesNotEqualExpectedValue(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $response->assertSelectorAttributeDoesNotEqual('input', 'name', 'someOtherInput');
    }

    public function testAttributeEqualsExpectedValue(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("Selector 'input' found with attribute 'name' set to value 'requiredValue'.");

        $response->assertSelectorAttributeDoesNotEqual('input', 'name', 'requiredValue');

    }

    public function testAttributeNotFound(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("Selector 'input' missing attribute 'miscellaneous'.");

        $response->assertSelectorAttributeDoesNotEqual('input', 'miscellaneous', 'requiredValue');
    }
}
