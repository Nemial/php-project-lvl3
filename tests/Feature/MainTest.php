<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MainTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMainPage()
    {
        $response = $this->get(route("home"));
        $response->assertOk();
    }
}
