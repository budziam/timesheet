<?php

namespace App\Models;

use App\Traits\HelpfulMethods;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int                                                                                                            $id
 * @property string                                                                                                         $fullname
 * @property string                                                                                                         $name
 * @property string                                                                                                         $password
 * @property string                                                                                                         $remember_token
 * @property bool                                                                                                           $is_admin
 * @property \Carbon\Carbon                                                                                                 $created_at
 * @property \Carbon\Carbon                                                                                                 $updated_at
 * @property \Carbon\Carbon                                                                                                 $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WorkLog[]                                            $workLogs
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $readNotifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User firstOrFail()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HelpfulMethods;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'fullname',
        'name',
        'email',
        'password',
    ];

    protected $attributes = [
        'is_admin' => false,
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        $this->attributes['password'] = bcrypt('');

        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|WorkLog
     */
    public function workLogs()
    {
        return $this->hasMany(WorkLog::class);
    }
}
