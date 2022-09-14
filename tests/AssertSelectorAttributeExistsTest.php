<?php

namespace Tests;

use Orchestra\Testbench\Concerns\CreatesApplication;
use PHPUnit\Framework\AssertionFailedError;
use SavvyWombat\LaravelAssertSelectorContains\AssertsWithSelectors;

class AssertSelectorAttributeExistsTest extends TestCase
{
    use AssertsWithSelectors;
    use CreatesApplication;

    public function testAttributeExists(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $response->assertSelectorAttributeExists('input[name=requiredValue]', 'required');
    }

    public function testSelectorNotFound(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("Selector 'input[name=doesNotExist]' missing from response.");


        $response->assertSelectorAttributeExists('input[name=doesNotExist]', 'required');
    }

    public function testAttributeNotFound(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("Selector 'input[name=notRequiredValue]' missing attribute 'required'.");


        $response->assertSelectorAttributeExists('input[name=notRequiredValue]', 'required');
    }
}
