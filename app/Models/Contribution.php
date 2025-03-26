<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contribution extends Model
{
    protected $fillable = [
        'amount',
        'user_id',
        'projet_id',
        'type',
        'description'
    ];

    public function projet() : BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
