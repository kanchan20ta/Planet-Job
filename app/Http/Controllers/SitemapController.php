<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Company;
use App\Models\Job;
use App\Models\Page;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    /**
     * Minimal dynamic XML sitemap covering all SEO-relevant, publicly
     * indexable URLs. For a very large catalog, split this into a
     * sitemap index + per-type sitemaps instead of one flat file.
     */
    public function index()
    {
        $urls = collect([
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('jobs.index'), 'priority' => '0.9'],
            ['loc' => route('blog.index'), 'priority' => '0.6'],
            ['loc' => route('faq'), 'priority' => '0.4'],
            ['loc' => route('contact.create'), 'priority' => '0.3'],
        ]);

        Job::active()->select('slug', 'updated_at')->chunk(500, function ($jobs) use ($urls) {
            foreach ($jobs as $job) {
                $urls->push(['loc' => route('jobs.show', $job), 'lastmod' => $job->updated_at->toAtomString(), 'priority' => '0.8']);
            }
        });

        foreach (Company::select('slug', 'updated_at')->get() as $company) {
            $urls->push(['loc' => route('companies.show', $company), 'lastmod' => $company->updated_at->toAtomString(), 'priority' => '0.5']);
        }

        foreach (Blog::published()->select('slug', 'updated_at')->get() as $blog) {
            $urls->push(['loc' => route('blog.show', $blog), 'lastmod' => $blog->updated_at->toAtomString(), 'priority' => '0.5']);
        }

        foreach (Page::where('is_active', true)->select('slug', 'updated_at')->get() as $page) {
            $urls->push(['loc' => route('pages.show', $page), 'lastmod' => $page->updated_at->toAtomString(), 'priority' => '0.4']);
        }

        return Response::view('sitemap', compact('urls'))->header('Content-Type', 'text/xml');
    }

    public function robots()
    {
        $content = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /employer\nDisallow: /jobseeker\nDisallow: /settings\nSitemap: " . route('sitemap');

        return Response::make($content, 200, ['Content-Type' => 'text/plain']);
    }
}
