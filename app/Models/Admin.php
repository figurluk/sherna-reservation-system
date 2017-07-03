<?php

/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 31/03/2017
 */


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin
 *
 * @property int            $id
 * @property string         $uid
 * @property string         $role
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User $user
 */
class Admin extends Model
{
    protected $table = "sherna_admins";
    protected $fillable = [
        'uid',
        'role'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'uid', 'uid');
    }


    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
        });
        static::deleting(function ($item) {
        });
    }
}
