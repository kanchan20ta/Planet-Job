<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq; // Adjust the namespace/model name if yours differs

class FaqSeeder extends Seeder
{
    /**
     * Seed the FAQ table for the two audiences shown on the FAQ page.
     * Category keys match $categoryLabels / $categoryIcons in faq.blade.php.
     */
    public function run(): void
    {
        $faqs = [
            // ---------- Job Seekers ----------
            [
                'category' => 'jobseeker',
                'question' => 'How do I create an account?',
                'answer'   => "Click on the \"Register\" button and fill in your details.",
                'order'    => 1,
            ],
            [
                'category' => 'jobseeker',
                'question' => 'How do I apply for a job?',
                'answer'   => "Browse jobs in the \"Find Jobs\" section and click \"Apply\".",
                'order'    => 2,
            ],
            [
                'category' => 'jobseeker',
                'question' => 'How do I update my resume after applying?',
                'answer'   => 'Log in and edit your profile information.',
                'order'    => 3,
            ],
            [
                'category' => 'jobseeker',
                'question' => 'Is this service free for job seekers?',
                'answer'   => 'Yes — our services are completely free for job seekers.',
                'order'    => 4,
            ],

            // ---------- Companies ----------
            [
                'category' => 'employer',
                'question' => 'How do I post a job?',
                'answer'   => "Log in and click \"Post a Job\".",
                'order'    => 1,
            ],
            [
                'category' => 'employer',
                'question' => 'How do I view applications for my job posting?',
                'answer'   => 'View the details of the specific job you posted.',
                'order'    => 2,
            ],
            [
                'category' => 'employer',
                'question' => 'How do I edit or remove a job listing?',
                'answer'   => "Use the \"Manage Jobs\" section.",
                'order'    => 3,
            ],
            [
                'category' => 'employer',
                'question' => 'Where can I find pricing details?',
                'answer'   => 'Pricing details can be found by logging in and visiting the pricing section.',
                'order'    => 4,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                [
                    'category' => $faq['category'],
                    'question' => $faq['question'],
                ],
                $faq
            );
        }
    }
}
