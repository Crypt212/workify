<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'seeker_id',
        // add any other fields you want to be mass assignable
    ];
    public function seeker(): BelongsTo
    {
        return $this->belongsTo(Seeker::class);
    }

}
