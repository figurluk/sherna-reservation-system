<?php

/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 21/02/2017
 */


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Reservation
 *
 * @property int            $id
 * @property int            $location_id
 * @property int            $tenant_uid
 * @property string         $start
 * @property string         $end
 * @property string         $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Reservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Reservation whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Reservation whereEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Reservation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Reservation whereLocationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Reservation whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Reservation whereStart($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Reservation whereTenantUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Reservation whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Reservation activeReservations()
 */
class Reservation extends Model
{
    use SoftDeletes;

    protected $table = "sherna_reservations";
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'location_id',
        'tenant_uid',
        'start',
        'end',
        'note',
        'day'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'tenant_uid', 'uid');
    }

    public function scopeActiveReservations($query)
    {
        return $query->where(function ($q) {
            $q->where('day', '=', date('Y-m-d'))->where('start', '>=', date('H:i:s'));
        })->orWhere(function ($q) {
            $q->where('day', '>', date('Y-m-d'));
        });
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
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
