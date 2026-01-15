<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::latest()->get();

        $content = view('sitemap', [
            'restaurants' => $restaurants,
        ])->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
