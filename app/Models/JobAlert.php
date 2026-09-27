<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'keyword', 'category_id', 'job_type_id', 'location',
        'frequency', 'is_active', 'last_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'last_sent_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }
}
