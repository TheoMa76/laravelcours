<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contribution extends Model
{
    protected $fillable = [
        'user_id',
        'projet_id',
        'contribution_type_id',
        'description',
        'material_details_id',
        'money_details_id',
        'volunteer_details_id',
        'approved',
        'approved_at',
        'approved_by_user_id'
    ];

    public function projet() : BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function contributionDetail() : BelongsTo
    {
        return $this->belongsTo(ContributionDetail::class);
    }

    public function contributionType() : BelongsTo
    {
        return $this->belongsTo(ContributionType::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedByUser() : BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_user_id');
    }

    public function moneyDetails() : BelongsTo
    {
        return $this->belongsTo(MoneyDetails::class);
    }
    public function volunteerDetails() : BelongsTo
    {
        return $this->belongsTo(VolunteerDetails::class);
    }
    public function materialDetails() : BelongsTo
    {
        return $this->belongsTo(ProjectMaterialNeeded::class);
    }


}
