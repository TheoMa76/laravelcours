<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerDetails extends Model
{
    protected $fillable = [
        'volunteer_hours_amount',
        'volunteer_role_needed_id',
        'days_list',
        'periods_list',
        'description',
        'contribution_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
