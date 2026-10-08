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

    // Payments are made by the company's owner (payments.user_id = companies.user_id).
    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id', 'user_id');
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class, 'user_id', 'user_id')->latestOfMany();
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
