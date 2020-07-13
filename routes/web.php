<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
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

Route::view("/", "pages/new")->name("/");

Route::post(
    '/pages',
    function () {
        ["domain" => $domain] = Request::all("domain");
        $url = parse_url($domain["name"]);
        $normalizedName = strtolower($url["host"]);
        $scheme = $url["scheme"];
        $normalizedUrl = "{$scheme}://{$normalizedName}";

        $validator = Validator::make(
            ['name' => $normalizedUrl],
            [
                'name' => 'required|unique:domains,name|url',
            ]
        );
        if ($validator->fails()) {
            flash('Url not valid')->error();
            return redirect(route("/"));
        }
        $timestamp = Carbon::now()->toDateTimeString();
        $id = DB::table('domains')->insertGetId(
            ["name" => $normalizedUrl, "updated_at" => $timestamp, "created_at" => $timestamp]
        );
        return redirect(route("pages.show", ['id' => $id]));
    }
)->name("pages.new");

Route::get(
    "/pages",
    function () {
        $domains = DB::table("domains")->get();
        return view("pages/index", ["domains" => $domains]);
    }
)->name("pages");

Route::get(
    '/pages/{id}',
    function ($id) {
        $domain = DB::table("domains")->where('id', $id)->first();
        return view("pages/show", ['domain' => $domain]);
    }
)->name("pages.show");
