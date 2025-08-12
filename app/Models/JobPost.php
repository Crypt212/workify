<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPost extends Model
{
    protected $fillable = ['title', 'description'];

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function seekers()
    {
        return $this->belongsToMany(JobSeeker::class, 'applications')
            ->withPivot('status')
            ->withTimestamps();
    }
}