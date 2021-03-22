<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testBasicTest(): void
    {
        $response = $this->get('/');
        var_dump($response);
        $response->assertStatus(200);
    }
}
