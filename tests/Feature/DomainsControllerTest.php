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
        DB::table('domain_checks')->insert(
            [
                [
                    'domain_id' => 1,
                    'status_code' => 200,
                    'h1' => '',
                    'keywords' => '',
                    'description' => '',
                    'updated_at' => now()->toDateTimeString(),
                    'created_at' => now()->toDateTimeString(),
                ],
            ]
        );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDomainsStore()
    {
        $domainData = ['name' => 'http://ok.ru'];
        $response = $this->post(route('domains.store', ['domain' => $domainData]));
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('domains', $domainData);
    }

    public function testDomainsIndex()
    {
        $response = $this->get(route("domains"));
        $response->assertOk();
    }

    public function testDomainsShow()
    {
        $domain = DB::table('domains')->first();
        $response = $this->get(route("domains.show", ['id' => $domain->id]));
        $response->assertOk();
    }
}
