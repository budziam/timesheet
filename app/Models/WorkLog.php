<?php
namespace App\Models;

use App\Bases\BaseModel;

/**
 * App\Models\WorkLog
 *
 * @property int $id
 * @property int $user_id
 * @property int $project_id
 * @property \Carbon\Carbon $starts_at
 * @property \Carbon\Carbon $ends_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WorkLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WorkLog whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WorkLog whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WorkLog whereStartsAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WorkLog whereEndsAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WorkLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WorkLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bases\BaseModel firstOrFail()
 * @mixin \Eloquent
 */
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
