<?php

namespace Tests;

use Orchestra\Testbench\Concerns\CreatesApplication;
use PHPUnit\Framework\AssertionFailedError;
use SavvyWombat\LaravelAssertSelectorContains\AssertsWithSelectors;

class AssertSelectorContainsTest extends TestCase
{
    use AssertsWithSelectors;
    use CreatesApplication;

    public function testSelectorFoundWithExpectedContent(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $response->assertSee('Test Document');
        $response->assertSelectorContains('h1', 'Test Document');
    }

    public function testSelectorNotFound(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The selector 'nothing' was not found in the response.");

        $response->assertSelectorContains('nothing', 'Test Document');
    }

    public function testSelectFoundWithDifferentContent(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The selector 'h1' did not contain the value 'Not the actual title'.");

        $response->assertSelectorContains('h1', 'Not the actual title');
    }
}