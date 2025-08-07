<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'post_id',
        // add any other fields you want to be mass assignable
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
