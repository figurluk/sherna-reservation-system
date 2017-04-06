<?php

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
        'uid', 'name', 'surname', 'email', 'block_number'
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
}
