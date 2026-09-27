<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jobs';

    protected $fillable = [
        'company_id', 'category_id', 'job_type_id', 'posted_by', 'title', 'slug',
        'description', 'responsibilities', 'requirements', 'benefits', 'vacancy',
        'salary_min', 'salary_max', 'salary_type', 'experience_level', 'education_level',
        'location', 'city', 'country', 'is_remote', 'deadline', 'status', 'is_featured',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'is_remote' => 'boolean',
            'is_featured' => 'boolean',
            'deadline' => 'date',
            'salary_min' => 'decimal:2',
            'salary_max' => 'decimal:2',
        ];
    }

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }

    public function poster()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skill');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function savedBy()
    {
        return $this->hasMany(SavedJob::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
