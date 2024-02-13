<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // query all data
        $models = ShortUrl::all();
        return view('short-url.index', [
            'models' => $models
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // parse url
        $parse_url = parseUrl($request->original_url);
        // cach key
        $cacheKey = "url-cache:$parse_url";
        $id = Cache::remember($cacheKey, CACHE_EXPIRED, function () use($parse_url) {
            // query duplicate url
            $model = ShortUrl::where('original_url', $parse_url)->first();
            if ($model) {
                return $model->id;
            }

            return null;
        });

        if ($id) {
            return redirect()->route('short-url.short-url.show', $id);
        }

        // create code
        if (!$request->code) {
            $request->merge(['code' => Str::random(10)]);
        }
        // get input data
        $requestData = $request->all();
        // set url
        $requestData['original_url'] = $parse_url;
        // create data
        $query = ShortUrl::create($requestData);

        if ($query) {
            // check error
            if ($query->errors) {
                return redirect()->back()->withErrors(['store' => $query->errors->all()]);
            }
        }

        return redirect()->route('short-url.short-url.show', $query->code);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShortUrl $shortUrl)
    {
        return view('short-url.show', ['model' => $shortUrl]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShortUrl $shortUrl)
    {
        return view('short-url.edit', ['model' => $shortUrl]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShortUrl $shortUrl)
    {
        // parse url
        $parse_url = parseUrl($request->original_url);
        // get input data
        $requestData = $request->all();
        // set url
        $requestData['original_url'] = $parse_url;
        // update date
        $shortUrl->update($requestData);
        if ($shortUrl) {
            // check error
            if ($shortUrl->errors) {
                return redirect()->back()->withErrors(['update' => $shortUrl->errors->all()]);
            }
        }

        return redirect()->route('short-url.short-url.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShortUrl $shortUrl)
    {
        // delete data
        $query = $shortUrl->delete();
        if ($query) {
            // Delete cache from a specific key
            Cache::forget("url-cache:$shortUrl->original_url");
            Cache::forget("redirect-cache:$shortUrl->code");
        }

        return redirect()->route('short-url.short-url.index');
    }

    public function redirect ($code) {
        try {
            // cach key
            $cacheKey = "redirect-cache:$code";
            $redirect = Cache::remember($cacheKey, CACHE_EXPIRED, function () use($code) {
                $shortUrl = ShortUrl::where('code', $code)->first();
                if ($shortUrl) {
                    // check url
                    $response = Http::get($shortUrl->original_url);
                    if($response->successful()) {
                        return $shortUrl->original_url;
                    }
                }

                return null;
            });

            if ($redirect) {
                return redirect()->to($redirect);
            }
            return abort(404);

        } catch (\Throwable $th) {
            return abort(404);
        }
    }
}
