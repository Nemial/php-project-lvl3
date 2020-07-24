<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $response = $this->get(route("home"));
        $response->assertOk();
    }

    public function testDomainsCreate()
    {
        $response = $this->get(route("domains.store"));
        $response->assertOk();
    }

    public function testDomainsStore()
    {
        $data = ['domain' => ['name' => 'http://ok.ru']];
        $response = $this->post(route('domains.store', $data));
        $response->assertRedirect(route('domains.show', ['id' => 2]));
        $this->assertDatabaseHas(
            'domains',
            [
                'name' => 'http://ok.ru',
            ]
        );
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
