<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JobSeeker extends Model
{
    protected $fillable = ['name', 'email'];

    public function jobPosts(): BelongsToMany
    {
        return $this->belongsToMany(JobPost::class, 'applications')
            ->withPivot('status')
            ->withTimestamps();
    }
}