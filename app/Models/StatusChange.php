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
 * App\Models\StatusChange
 *
 * @property int $id
 * @property int $status_id
 * @property int $reservation_id
 * @property string $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatusChange whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatusChange whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatusChange whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatusChange whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatusChange whereReservationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatusChange whereStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatusChange whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StatusChange extends Model
{
    use SoftDeletes;

    protected $table = "sherna_statuses_changes";
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'status_id',
        'reservation_id',
        'note'
    ];


    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
        });
        static::deleting(function ($item) {
        });
    }
}
