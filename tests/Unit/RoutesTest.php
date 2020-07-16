<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RoutesTest extends TestCase
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
                [
                    "name" => "http://duckduck.ru",
                    "updated_at" => now()->toDateTimeString(),
                    "created_at" => now()->toDateTimeString(),
                ],
            ]
        );
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testMainPage()
    {
        $response = $this->get(route("/"));
        $response->assertSuccessful();
    }

    public function testCreatePage()
    {
        $response = $this->post(route("pages.new"), ["domain" => ["name" => "https://ok.ru"]]);
        $response->assertRedirect(route("pages.show", ["id" => 3]));
    }

    public function testIndexPage()
    {
        $response = $this->get(route("pages"));
        $response->assertOk();
    }

    public function testPageShow()
    {
        $response = $this->get(route("pages.show", ["id" => 2]));
        $response->assertOk();
    }

    public function testPageCheck()
    {
        Http::fake(
            [
                'https://dark.com' => Http::response(['foo' => 'bar'], 200, ['Headers']),
            ]
        );

        $response = $this->post(route('pages.check', ['id' => 1]));
        $response->assertRedirect(route('pages.show', ['id' => 1]));
    }
}
