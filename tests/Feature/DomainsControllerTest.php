<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DomainsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table("domains")->insert(
            [
                [
                    "name" => "https://dark.com",
                    "updated_at" => now()->toDateTimeString(),
                    "created_at" => now()->toDateTimeString(),
                ],
            ]
        );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMainPage()
    {
        $response = $this->get(route("/"));
        $response->assertOk();
    }

    public function testDomainsCreate()
    {
        $response = $this->get(route("domains.new"));
        $response->assertOk();
    }

    public function testDomainsIndex()
    {
        $response = $this->get(route("domains"));
        $response->assertOk();
    }

    public function testDomainsShow()
    {
        $response = $this->get(route("domains.show", ['id' => 1]));
        $response->assertOk();
    }
}
