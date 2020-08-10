<?php

use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

Route::view('/', 'home')->name('home');

Route::post(
    '/domains',
    function () {
        $domain = Request::input('domain');

        $validator = Validator::make(
            $domain,
            [
                'name' => 'required|unique:domains,name|url',
            ]
        );

        if ($validator->fails()) {
            session(['nameUrl' => $domain['name']]);
            return redirect()->route('home')->withErrors($validator->errors());
        }

        $url = parse_url($domain['name']);
        $normalizedName = mb_strtolower($url['host']);
        $scheme = $url['scheme'] ?? 'https';
        $normalizedUrl = "{$scheme}://{$normalizedName}";

        $currentDomain = DB::table('domains')->where('name', $domain['name'])->first('id');

        if ($currentDomain) {
            flash('Url already exists ')->info();
            return redirect()->route('domains.show', ['id' => $currentDomain->id]);
        }

        $timestamp = Carbon::now()->toDateTimeString();
        $id = DB::table('domains')->insertGetId(
            ['name' => $normalizedUrl, 'updated_at' => $timestamp, 'created_at' => $timestamp]
        );

        flash('Url has been added ')->success();
        return redirect()->route('domains.show', ['id' => $id]);
    }
)->name('domains.store');

Route::get(
    '/domains',
    function () {
        $domains = DB::table('domains')->get(['id', 'name']);
        $checks = DB::table('domain_checks')
            ->select(DB::raw('DISTINCT ON ("domain_id") domain_id, created_at, status_code'))
            ->orderBy('domain_id')
            ->orderBy('created_at', 'desc')
            ->distinct('domain_id')
            ->get()->keyBy('domain_id')->toArray();
        return view('domains/index', ['domains' => $domains, 'checks' => $checks]);
    }
)->name("domains");

Route::get(
    '/domains/{id}',
    function ($id) {
        $domain = DB::table('domains')->where('id', $id)->first();
        abort_unless($domain, 404);

        $checks = DB::table('domain_checks')->where('domain_id', $id)->get();

        return view('domains/show', ['domain' => $domain, 'checks' => $checks]);
    }
)->name('domains.show');

Route::post(
    '/domains/{id}/checks',
    function ($id) {
        $domain = DB::table('domains')->where('id', $id)->first('name');
        abort_unless($domain, 404);
        $timestamp = now()->toDateTimeString();

        try {
            $response = Http::get($domain->name);
            $document = new Document($response->body());

            $h1 = optional(
                $document->first('h1::text'),
                function ($unFormatH1) {
                    return Str::limit($unFormatH1, 29, '...');
                }
            );

            if ($document->has('meta[name=description]')) {
                $unFormatDescription = $document->first('meta[name=description]')->first('meta::attr(content)');
                $description = Str::limit($unFormatDescription, 30, '...');
            }

            $keywords = optional(
                $document->first('meta[name=keywords]'),
                function ($document) {
                    $unFormatKeywords = $document->first('meta::attr(content)');
                    return Str::limit($unFormatKeywords, 30, '...');
                }
            );


            DB::table('domain_checks')->insert(
                [
                    'domain_id' => $id,
                    'status_code' => $response->status(),
                    'h1' => is_null($h1) ? '' : $h1,
                    'keywords' => is_null($keywords) ? '' : $keywords,
                    'description' => $description ?? '',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]
            );
            flash('Website has been checked!')->info();
        } catch (RequestException $e) {
            flash('Failed to connect to the website')->error();
        }


        return redirect()->route('domains.show', ['id' => $id]);
    }
)->name("domains.check");
