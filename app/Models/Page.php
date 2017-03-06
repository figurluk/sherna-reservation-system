<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Page
 *
 * @property int            $id
 * @property string         $name
 * @property string         $code
 * @property string         $content
 * @property bool           $public
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page wherePublic($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PageText[] $pageText
 */
class Page extends Model
{
    protected $table = "sherna_pages";
    protected $fillable = [
        'name',
        'code',
        'public',
    ];

    public function pageText()
    {
        return $this->hasMany(PageText::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($item) {
            if ($item->code == '') {
                $code = static::makeCode($item->name).'-'.substr(uniqid(), 0, 2);
                $item->code = $code;
                $item->save();
            }
        });
        static::deleting(function ($item) {
        });
    }

    private static function makeCode($string)
    {
        $unwanted_array = ['Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A',
                           'Ç' => 'C', 'È' => 'E', 'É' => 'E',
                           'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
                           'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
                           'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
                           'å' => 'a', 'æ' => 'a', 'ç' => 'c',
                           'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o',
                           'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ů' => 'u',
                           'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', ' ' => '_'];

        return strtolower(strtr($string, $unwanted_array));
    }
}
