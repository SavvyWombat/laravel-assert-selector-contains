<?php

namespace Tests;

use Orchestra\Testbench\Concerns\CreatesApplication;
use PHPUnit\Framework\AssertionFailedError;
use SavvyWombat\LaravelAssertSelectorContains\AssertsWithSelectors;

class AssertSelectorAttributeDoesNotExistTest extends TestCase
{
    use CreatesApplication;
    use AssertsWithSelectors;

    public function testSelectorFoundWithoutAttribute(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $response->assertSelectorAttributeDoesNotExist('input[name=notRequiredValue]', 'required');
    }

    public function testSelectorFoundWithAttribute(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("Selector 'input[name=requiredValue]' found with attribute 'required'.");
        
        $response->assertSelectorAttributeDoesNotExist('input[name=requiredValue]', 'required');
    }

    public function testSelectorNotFound(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("Selector 'input[name=someOtherInput]' missing from response.");

        $response->assertSelectorAttributeDoesNotExist('input[name=someOtherInput]', 'required');
    }
}