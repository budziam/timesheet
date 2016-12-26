<?php

namespace App\Models;

use App\Traits\HelpfulMethods;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property int                                                                                                            $id
 * @property string                                                                                                         $name
 * @property string                                                                                                         $email
 * @property string                                                                                                         $password
 * @property string                                                                                                         $remember_token
 * @property \Carbon\Carbon                                                                                                 $created_at
 * @property \Carbon\Carbon                                                                                                 $updated_at
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
 * @mixin \Eloquent
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WorkLog[] $workLogs
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User firstOrFail()
 */
class User extends Authenticatable
{
    use HelpfulMethods;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|WorkLog
     */
    public function workLogs()
    {
        return $this->hasMany(WorkLog::class);
    }
}
