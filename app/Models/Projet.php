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
        'short_description',
        'status',
        'start_date',
        'money_goal',
        'volunteer_hour_goal',
        'end_date',
        'user_id',
        'image',
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

    public function projectMaterialNeeded() : HasMany
    {
        return $this->hasMany(ProjectMaterialNeeded::class);
    }

    public function volunteerRoleNeeded() : HasMany
    {
        return $this->hasMany(VolunteerRoleNeeded::class);
    }
}
