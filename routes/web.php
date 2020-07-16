<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'pages/new')->name('/');

Route::post(
    '/pages',
    function () {
        ['domain' => $domain] = Request::all('domain');
        $validator = Validator::make(
            $domain,
            [
                'name' => 'required|unique:domains,name|url',
            ]
        );

        if ($validator->fails()) {
            flash('Url not valid')->error();
            return redirect(route('/'));
        }

        $url = parse_url($domain['name']);
        $normalizedName = strtolower($url['host']);
        $scheme = $url['scheme'];
        $normalizedUrl = "{$scheme}://{$normalizedName}";

        $timestamp = Carbon::now()->toDateTimeString();
        $id = DB::table('domains')->insertGetId(
            ['name' => $normalizedUrl, 'updated_at' => $timestamp, 'created_at' => $timestamp]
        );

        return redirect(route('pages.show', ['id' => $id]));
    }
)->name('pages.new');

Route::get(
    '/pages',
    function () {
        $domains = DB::table('domain_checks')
            ->leftJoin('domains', 'domains.id', '=', 'domain_checks.domain_id')
            ->orderBy('domains.id')
            ->orderBy('domain_checks.created_at', 'desc')
            ->distinct('domains.id')
            ->get(['domains.id', 'domains.name', 'domain_checks.created_at', 'status_code',]);

        return view('pages/index', ['domains' => $domains]);
    }
)->name("pages");

Route::get(
    '/pages/{id}',
    function ($id) {
        $domain = DB::table('domains')->where('id', $id)->first();
        $checks = DB::table('domain_checks')->where('domain_id', $id)->get();

        return view('pages/show', ['domain' => $domain, 'checks' => $checks]);
    }
)->name('pages.show');

Route::post(
    '/pages/{id}/checks',
    function ($id) {
        $timestamp = now()->toDateTimeString();
        $domain = DB::table('domains')->where('id', $id)->first('name');
        $response = Http::get($domain->name);
        DB::table('domain_checks')->insert(
            [
                'domain_id' => $id,
                'status_code' => $response->status(),
                'h1' => '',
                'keywords' => '',
                'description' => '',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]
        );
        flash('Website has been checked!')->info();

        return redirect(route('pages.show', ['id' => $id]));
    }
)->name("pages.check");
