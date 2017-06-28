<?php
namespace App\Models;

use App\Bases\BaseModel;
use Carbon\Carbon;

/**
 * App\Models\Project
 *
 * @property int                                                                      $id
 * @property string                                                                   $lkz
 * @property string                                                                   $kerg
 * @property string                                                                   $name
 * @property int                                                                      $value
 * @property string                                                                   $description
 * @property string                                                                   $color
 * @property \Carbon\Carbon|null                                                      $ends_at
 * @property \Carbon\Carbon                                                           $created_at
 * @property \Carbon\Carbon                                                           $updated_at
 * @property-read bool                                                                $active
 * @property-read string                                                              $full_name
 * @property-read string|null                                                         $real_color
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProjectGroup[] $groups
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WorkLog[]      $workLogs
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereLkz($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereKerg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereValue($value)
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
        'lkz',
        'kerg',
        'name',
        'description',
        'value',
        'color',
        'ends_at',
    ];

    protected $casts = [
        'ends_at' => 'date',
        'value'   => 'int',
    ];

    protected $attributes = [
        'description' => '',
        'value'       => 0,
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
        $query->where('ends_at', '>=', Carbon::now())->orWhereNull('ends_at');
    }

    public function getActiveAttribute() : bool
    {
        return $this->ends_at === null || $this->ends_at->gte(Carbon::now());
    }

    public function getRealColorAttribute()
    {
        if ($this->color !== null) {
            return $this->color;
        }

        if ($this->groups->isNotEmpty()) {
            return $this->groups->first()->color;
        }

        return null;
    }

    public function getFullNameAttribute()
    {
        return $this->lkz . ', ' . $this->kerg . ' ' . $this->name;
    }
}
