<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        // add any other fields you want to be mass assignable
    ];

    public function post(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
