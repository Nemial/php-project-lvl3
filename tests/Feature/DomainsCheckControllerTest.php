<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DomainsCheckControllerTest extends TestCase
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
    public function testDomainsCheck()
    {
        Http::fake(
            [
                'https://dark.com' => Http::response([], 200, []),
            ]
        );
        $domain = DB::table('domains')->first();
        $response = $this->post(route('domains.check', ['id' => $domain->id]));
        $response->assertRedirect(route('domains.show', ['id' => $domain->id]));
    }
}
