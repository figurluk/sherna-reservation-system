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
 * App\Models\Console
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Console whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Console whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Console whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Console whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Console whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Console extends Model
{
    use SoftDeletes;

    protected $table = "sherna_consoles";
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name'
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
