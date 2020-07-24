<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use DiDom\Document;

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

Route::view('/', 'domains/new')->name('home');

Route::post(
    '/domains',
    function () {
        ['domain' => $domain] = Request::all('domain');
        $currentDomain = DB::table('domains')->where('name', $domain['name'])->first('id');

        if (!is_null($currentDomain)) {
            return redirect()->route('domains.show', ['id' => $currentDomain->id]);
        }

        $validator = Validator::make(
            $domain,
            [
                'name' => 'required|unique:domains,name|url',
            ]
        );

        if ($validator->fails()) {
            flash('Url not valid')->error();
            return redirect()->route('home');
        }

        $url = parse_url($domain['name']);
        $normalizedName = strtolower($url['host']);
        $scheme = $url['scheme'];
        $normalizedUrl = "{$scheme}://{$normalizedName}";

        $timestamp = Carbon::now()->toDateTimeString();
        $id = DB::table('domains')->insertGetId(
            ['name' => $normalizedUrl, 'updated_at' => $timestamp, 'created_at' => $timestamp]
        );

        return redirect()->route('domains.show', ['id' => $id]);
    }
)->name('domains.store');

Route::get(
    '/domains',
    function () {
        $domains = DB::table('domain_checks')
            ->leftJoin('domains', 'domains.id', '=', 'domain_checks.domain_id')
            ->orderBy('domains.id')
            ->orderBy('domain_checks.created_at', 'desc')
            ->distinct('domains.id')
            ->get(['domains.id', 'domains.name', 'domain_checks.created_at', 'status_code',]);

        return view('domains/index', ['domains' => $domains]);
    }
)->name("domains");

Route::get(
    '/domains/{id}',
    function ($id) {
        $domain = DB::table('domains')->where('id', $id)->first();

        if (is_null($domain)) {
            return redirect()->route('home')->setStatusCode(404);
        }

        $checks = DB::table('domain_checks')->where('domain_id', $id)->get();

        return view('domains/show', ['domain' => $domain, 'checks' => $checks]);
    }
)->name('domains.show');

Route::post(
    '/domains/{id}/checks',
    function ($id) {
        $timestamp = now()->toDateTimeString();
        $domain = DB::table('domains')->where('id', $id)->first('name');
        $response = Http::get($domain->name);
        $document = new Document($response->body());

        if ($document->has('h1')) {
            $unFormatH1 = $document->first('h1::text');
            $h1 = mb_strlen($unFormatH1) > 30 ? substr_replace($unFormatH1, '...', 30) : $unFormatH1;
        }

        if ($document->has('meta[name=description]')) {
            $unFormatDescription = $document->first('meta[name=description]')->first('meta::attr(content)');
            $description = mb_strlen($unFormatDescription) > 30 ? substr_replace(
                $unFormatDescription,
                '...',
                30
            ) : $unFormatDescription;
        }

        if ($document->has('meta[name=keywords]')) {
            $unFormatKeywords = $document->first('meta[name=keywords]')->first('meta::attr(content)');
            $keywords = mb_strlen($unFormatKeywords) > 30 ? substr_replace(
                $unFormatKeywords,
                '...',
                30
            ) : $unFormatKeywords;
        }


        DB::table('domain_checks')->insert(
            [
                'domain_id' => $id,
                'status_code' => $response->status(),
                'h1' => $h1 ?? '',
                'keywords' => $keywords ?? '',
                'description' => $description ?? '',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]
        );
        flash('Website has been checked!')->info();

        return redirect()->route('domains.show', ['id' => $id]);
    }
)->name("domains.check");
