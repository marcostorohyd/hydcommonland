<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Config extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'config';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'name';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'value',
        'created_by_id',
        'updated_by_id'
    ];

    /**
     * Get data by locale
     *
     * @param string $name
     * @param string $locale
     * @return string
     */
    public static function getByLocale(string $name, string $locale = null)
    {
        if (is_null($locale)) {
            $locale = locale();
        }

        $data = self::where('name', 'like', $name . '_' . $locale)
                    ->pluck('value')
                    ->all();

        if (empty($data)) {
            $fallback = config('app.fallback_locale');
            if ($fallback != $locale) {
                return self::getByLocale($name, $fallback);
            }
        }

        return $data ? $data[0] : '';
    }

    /**
     * Get about image path.
     *
     * @return string
     */
    public static function aboutLeafletImageUrl($file)
    {
        return Storage::url("public/config/{$file}");
    }
}
