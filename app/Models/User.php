<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 15/02/2017
 * Time: 19:40
 */

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 * @property int                                                                                                            $id
 * @property string                                                                                                         $name
 * @property string                                                                                                         $email
 * @property string                                                                                                         $password
 * @property string                                                                                                         $remember_token
 * @property \Carbon\Carbon                                                                                                 $created_at
 * @property \Carbon\Carbon                                                                                                 $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @property string                                                                                                         $uid
 * @property string                                                                                                         $surname
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereSurname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUid($value)
 * @property string                                                                                                         $role
 * @property int                                                                                                            $block_number
 * @property \Carbon\Carbon                                                                                                 $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereBlockNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRole($value)
 * @property-read \App\Models\Admin                                                                                         $admin
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @property string|null                                                                                                    $image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereImage($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reservation[] $reservations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Badge[] $badges
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'name', 'surname', 'email', 'block_number', 'image', 'role',
		 'banned'
    ];

    protected $dates = ['deleted_at'];

    public function role()
    {
        if ($this->isSuperAdmin()) {
            return 'super_admin';
        } else if ($this->isAdmin()) {
            return 'admin';
        } else {
            return 'uzivatel';
        }
    }

    public function isAdmin()
    {
        return ($this->admin != null && ($this->admin->role == 'admin' || $this->admin->role == 'super_admin')) || (in_array($this->uid, explode(',', env('SUPER_ADMINS'))));
    }

    public function isSuperAdmin()
    {
        return ($this->admin != null && $this->admin->role == 'super_admin') || (in_array($this->uid, explode(',', env('SUPER_ADMINS'))));
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'uid', 'uid');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'tenant_uid', 'uid');
    }
	
	public function badges()
	{
		return $this->belongsToMany(Badge::class, 'sherna_badges_users');
	}
}
