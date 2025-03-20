<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Projet extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'start_date',
        'goal',
        'end_date',
        'user_id',
    ];

    protected $casts = [
        'start_date' => 'date', 
        'end_date' => 'date',   
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contributions() : HasMany
    {
        return $this->hasMany(Contribution::class);
    }
}
