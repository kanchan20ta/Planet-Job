<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Page;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('pages.show', compact('page'));
    }

    public function faq()
    {
        return view('pages.faq', [
            'faqs' => Faq::where('is_active', true)->orderBy('category')->orderBy('order')->get()->groupBy('category'),
        ]);
    }
}
