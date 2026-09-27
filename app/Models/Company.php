<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'slug', 'logo', 'cover_image', 'description',
        'industry', 'founded_year', 'company_size', 'website', 'email',
        'phone', 'address', 'city', 'country', 'facebook', 'linkedin', 'is_verified',
    ];

    protected function casts(): array
    {
        return ['is_verified' => 'boolean'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function activeJobs()
    {
        return $this->hasMany(Job::class)->where('status', 'active');
    }

    public function reviews()
    {
        return $this->hasMany(CompanyReview::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
