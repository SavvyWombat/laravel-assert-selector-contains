<?php

namespace Tests;

use Orchestra\Testbench\Concerns\CreatesApplication;
use PHPUnit\Framework\AssertionFailedError;
use SavvyWombat\LaravelAssertSelectorContains\AssertsWithSelectors;

class AssertSelectorDoesNotContainTest extends TestCase
{
    use AssertsWithSelectors;
    use CreatesApplication;

    public function testSelectorFoundWithoutExpectedContent(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $response->assertSelectorDoesNotContain('label', 'Does not exist');
    }

    public function testSelectorNotFound(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("Selector 'no-element' missing from response.");

        $response->assertSelectorDoesNotContain('no-element', 'Does not exist');
    }

    public function testSelectorFoundWithExpectedContent(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("Selector 'label' found with content 'Label for required value'.");

        $response->assertSelectorDoesNotContain('label', 'Label for required value');
    }
}
