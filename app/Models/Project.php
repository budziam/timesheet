<?php
namespace App\Models;

use App\Bases\BaseModel;

class Project extends BaseModel
{
    protected $fillable = [
        'name',
        'ends_at',
    ];

    protected $dates = [
        'ends_at',
    ];

    public function groups()
    {
        return $this->belongsToMany(ProjectGroup::class);
    }

    public function workLogs()
    {
        return $this->hasMany(WorkLog::class);
    }
}
