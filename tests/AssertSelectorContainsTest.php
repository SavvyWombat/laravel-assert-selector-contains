<?php

namespace Tests;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Mockery;
use Illuminate\Foundation\Testing\TestCase;
use Orchestra\Testbench\Concerns\CreatesApplication;
use PHPUnit\Framework\AssertionFailedError;
use SavvyWombat\LaravelAssertSelectorContains\AssertsWithSelectors;

class AssertSelectorContainsTest extends TestCase
{
    use AssertsWithSelectors;
    use CreatesApplication;

    public function testAssertSelectorContains(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $response->assertSee('Test Document');
        $response->assertSelectorContains('h1', 'Test Document');
    }

    public function testAssertSelectorNotFound(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The selector 'nothing' was not found in the response.");

        $response->assertSelectorContains('nothing', 'Test Document');
    }

    public function testAssertSelectorFoundWithDifferentContent(): void
    {
        $response = $this->makeMockResponse([
            'render' => $this->loadTestDocument(),
        ]);

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The selector 'h1' did not contain the value 'Not the actual title'.");

        $response->assertSelectorContains('h1', 'Not the actual title');
    }

    private function loadTestDocument(): string
    {
        return <<<EODOC
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Test Document</title>
</head>
<body>
    <h1>Test Document</h1>
</body>
</html>
EODOC;

    }

    private function makeMockResponse($content): TestResponse
    {
        $baseResponse = tap(new Response(), function ($response) use ($content) {
            $response->setContent(Mockery::mock(View::class, $content));
        });

        return TestResponse::fromBaseResponse($baseResponse);
    }
}
