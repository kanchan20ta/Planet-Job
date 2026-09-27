<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SavedJobFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->jobseeker(),
            'job_id' => Job::factory(),
        ];
    }
}
