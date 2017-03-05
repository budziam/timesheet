<?php
namespace App\Models;

use App\Bases\BaseModel;

/**
 * App\Models\WorkLog
 *
 * @property int                      $id
 * @property int                      $user_id
 * @property int                      $project_id
 * @property \Carbon\Carbon           $date
 * @property integer                  $time_fieldwork
 * @property integer                  $time_office
 * @property \Carbon\Carbon           $created_at
 * @property \Carbon\Carbon           $updated_at
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\User    $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WorkLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WorkLog whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WorkLog whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WorkLog whereTimeFieldwork($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WorkLog whereTimeOffice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WorkLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WorkLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WorkLog extends BaseModel
{
    protected $fillable = [
        'date',
        'project_id',
        'time_fieldwork',
        'time_office',
        'user_id',
    ];

    protected $dates = [
        'date',
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
