<?php
namespace App\Models;

use App\Bases\Model;
use Carbon\Carbon;

/**
 * App\Models\Project
 *
 * @property int                                                                      $id
 * @property string                                                                   $lkz
 * @property string                                                                   $kerg
 * @property string                                                                   $name
 * @property int                                                                      $value
 * @property int                                                                      $cost
 * @property string                                                                   $description
 * @property string                                                                   $color
 * @property null|Customer                                                            $customer_id
 * @property null|\Carbon\Carbon                                                      $ends_at
 * @property \Carbon\Carbon                                                           $created_at
 * @property \Carbon\Carbon                                                           $updated_at
 * @property-read bool                                                                $active
 * @property-read string                                                              $full_name
 * @property-read string|null                                                         $real_color
 * @property-read null|\App\Models\Customer                                           $customer
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
 * @mixin \Eloquent
 */
class Project extends Model
{
    protected $fillable = [
        'lkz',
        'kerg',
        'name',
        'description',
        'value',
        'cost',
        'color',
        'ends_at',
        'customer_id',
    ];

    protected $casts = [
        'ends_at' => 'date',
    ];

    protected $attributes = [
        'description' => '',
        'cost'        => 0,
        'value'       => 0,
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function groups()
    {
        return $this->belongsToMany(ProjectGroup::class);
    }

    public function workLogs()
    {
        return $this->hasMany(WorkLog::class);
    }

    public function getValueAttribute($value) : float
    {
        return round($value / 100, 2);
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = (int)($value * 100);
    }

    public function getCostAttribute($cost) : float
    {
        return round($cost / 100, 2);
    }

    public function setCostAttribute($cost)
    {
        $this->attributes['cost'] = (int)($cost * 100);
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

        if ($this->customer !== null) {
            return $this->customer->color;
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

    public function scopeActive($query)
    {
        $query->where('ends_at', '>=', Carbon::now())->orWhereNull('ends_at');
    }

    public function complete()
    {
        $this->update(['ends_at' => Carbon::now()]);
    }
}
