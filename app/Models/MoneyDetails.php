<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoneyDetails extends Model
{
    protected $fillable = [
        'amount',
        'message',
        'contribution_id'
    ];

    public function contribution()
    {
        return $this->belongsTo(Contribution::class);
    }
}
