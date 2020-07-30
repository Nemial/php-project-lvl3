<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DomainsCheckControllerTest extends TestCase
{
    use RefreshDatabase;

    private $id;

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
        $domain = DB::table('domains')->first(['id']);
        $this->id = $domain->id;
    }

    public function makePathToFixtures($file)
    {
        $parts = [__DIR__, '..', "fixtures", $file];
        return implode("/", $parts);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testDomainsCheck($body)
    {
        $parsedBody = file_get_contents($this->makePathToFixtures($body));
        Http::fake(
            [
                'https://dark.com' => Http::response($parsedBody, 200, []),
            ]
        );
        $response = $this->post(route('domains.check', ['id' => $this->id]));
        $response->assertRedirect(route('domains.show', ['id' => $this->id]));
        $this->assertDatabaseHas(
            'domain_checks',
            [
                'h1' => 'Hello',
                'description' => 'Desc',
                'keywords' => 'test',
            ]
        );
    }

    public function dataProvider()
    {
        return [
            'body' => ['body.html'],
        ];
    }
}
