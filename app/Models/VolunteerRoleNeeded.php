<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerRoleNeeded extends Model
{
    protected $fillable = [
        'name',
        'description',
        'volunteer_hours_needed',
        'project_id'
    ];

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
