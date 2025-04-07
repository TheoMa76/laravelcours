<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContributionType extends Model
{
    protected $fillable = [
        'name', //Financière , Matérielle, Bénévolat
        'description'
    ];

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }
}
