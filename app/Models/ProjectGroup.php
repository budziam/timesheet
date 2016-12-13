<?php
namespace App\Models;

use App\Bases\BaseModel;

class ProjectGroup extends BaseModel
{
    protected $fillable = [
        'name',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
