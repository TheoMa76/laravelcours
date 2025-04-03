<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMaterialNeeded extends Model
{
    protected $fillable = [
        'material_category_id',
        'additional',
        'project_id',
    ];

    public function project()
    {
        return $this->belongsTo(Projet::class);
    }

    public function materialCategory()
    {
        return $this->belongsTo(MaterialCategory::class);
    }
}
