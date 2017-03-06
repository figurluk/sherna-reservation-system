<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PageText
 *
 * @property int $id
 * @property int $page_id
 * @property int $language_id
 * @property string $content
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Language $languages
 * @property-read \App\Models\Page $page
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageText ofLang($langCode)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageText whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageText whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageText whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageText whereLanguageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageText wherePageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageText whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PageText extends Model
{
    protected $table = "sherna_pages_texts";
    protected $guarded = [
        //
    ];

    public function scopeOfLang($query, $langCode)
    {
        return $query->where('language_id', Language::where('code', $langCode)->first()->id);
    }

    public function languages()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
        });
    }
}
