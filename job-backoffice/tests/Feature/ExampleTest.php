<?php
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_home_redirects()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }
}