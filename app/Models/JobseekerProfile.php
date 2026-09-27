<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobseekerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'headline', 'bio', 'resume_path', 'experience_level',
        'experience_years', 'current_salary', 'expected_salary', 'date_of_birth',
        'gender', 'address', 'city', 'country', 'is_available', 'profile_public',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'is_available' => 'boolean',
            'profile_public' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
