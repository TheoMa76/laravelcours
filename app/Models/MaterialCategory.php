<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function projectMaterialNeeded()
    {
        return $this->hasMany(ProjectMaterialNeeded::class);
    }
}
