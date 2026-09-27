<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'role', 'type', 'price', 'duration_days', 'job_post_limit',
        'featured_job_limit', 'cv_access', 'description', 'features', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'cv_access' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }
}
