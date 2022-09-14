<?php

namespace Tests;

use Orchestra\Testbench\Concerns\CreatesApplication;
use PHPUnit\Framework\AssertionFailedError;
use SavvyWombat\LaravelAssertSelectorContains\AssertsWithSelectors;

class AssertSelectorContainsExists extends TestCase
{
    use AssertsWithSelectors;
    use CreatesApplication;

    public function testSelectorFound(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $response->assertSelectorExists('h1');
    }

    public function testSelectorNotFound(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The selector 'does-not-exist' was not found in the response.");

        $response->assertSelectorExists('does-not-exist');
    }
}
