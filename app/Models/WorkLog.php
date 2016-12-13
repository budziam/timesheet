<?php
namespace App\Models;

use App\Bases\BaseModel;

class WorkLog extends BaseModel
{
    protected $fillable = [
        'ends_at',
        'project_id',
        'starts_at',
        'user_id',
    ];

    protected $dates = [
        'ends_at',
        'starts_at',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
