<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialDetails extends Model
{
    protected $fillable = [
        'material_category_id',
        'quantity',
        'description',
        'project_material_needed_id'
    ];

    public function projectMaterialNeeded()
    {
        return $this->belongsTo(ProjectMaterialNeeded::class);
    }

    public function materialCategory()
    {
        return $this->belongsTo(MaterialCategory::class);
    }
}
