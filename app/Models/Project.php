<?php
namespace App\Models;

use App\Bases\BaseModel;
use Carbon\Carbon;

/**
 * App\Models\Project
 *
 * @property int                                                                      $id
 * @property string                                                                   $name
 * @property string                                                                   $description
 * @property string                                                                   $color
 * @property \Carbon\Carbon                                                           $ends_at
 * @property \Carbon\Carbon                                                           $created_at
 * @property \Carbon\Carbon                                                           $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProjectGroup[] $groups
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WorkLog[]      $workLogs
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereEndsAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project active()
 * @method static \Illuminate\Database\Query\Builder|\App\Bases\BaseModel firstOrFail()
 * @mixin \Eloquent
 */
class Project extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'color',
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

    public function scopeActive($query)
    {
        $query->where('ends_at', '>=', Carbon::now());
    }
}
