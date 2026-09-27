<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => 'Planet Job Private Limited connects talented job seekers with opportunities across Nepal. Our mission is to make hiring simple, transparent, and effective for both employers and job seekers.',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => 'This Privacy Policy explains how Planet Job Portal collects, uses, and protects your personal information when you use our platform.',
            ],
            [
                'title' => 'Terms and Conditions',
                'slug' => 'terms-and-conditions',
                'content' => 'By using Planet Job Portal, you agree to these Terms and Conditions governing job postings, applications, and account usage.',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                [
                    'title' => $page['title'],
                    'content' => $page['content'],
                    'meta_title' => $page['title'] . ' - Planet Job Portal',
                    'meta_description' => $page['title'] . ' for Planet Job Private Limited.',
                    'is_active' => true,
                ]
            );
        }
    }
}
