<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        // Attach a company profile to the fixed demo employer
        $demoEmployer = User::where('email', 'employer@planetjob.com')->first();

        if ($demoEmployer && ! $demoEmployer->company) {
            Company::factory()->create([
                'user_id' => $demoEmployer->id,
                'name' => 'Planet Job Private Limited',
                'slug' => 'planet-job-private-limited',
                'is_verified' => true,
            ]);
        }

        // 19 more random employer companies for demo variety
        Company::factory()->count(19)->create();
    }
}
