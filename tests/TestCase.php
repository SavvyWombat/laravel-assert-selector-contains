<?php

namespace Tests;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Mockery;

abstract class TestCase extends BaseTestCase
{
    protected function loadTestDocument(): string
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

    <input type="text" name="requiredValue" required/>
    <input type="text" name="notRequiredValue"/>
</body>
</html>
EODOC;
    }

    protected function makeMockResponse($content): TestResponse
    {
        $baseResponse = tap(new Response(), function ($response) use ($content) {
            $response->setContent(Mockery::mock(View::class, $content));
        });

        return TestResponse::fromBaseResponse($baseResponse);
    }
}
