<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $fillable = [
        'seeker_id',
        'post_id',
        'employer_id',
        'status',
    ];

    public function seeker(): BelongsTo
    {
        return $this->belongsTo(Seeker::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }
}
