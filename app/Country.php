<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;
    use Translatable;

    /**
     * The attributes for translation.
     *
     * @var array
     */
    public $translatedAttributes = ['name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_id',
        'created_by_id',
        'updated_by_id',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * Get the contact that owns the country.
     */
    public function contact()
    {
        return $this->belongsTo(\App\Directory::class);
    }

    /**
     * Get the demo case studies for the country.
     */
    public function demos()
    {
        return $this->hasMany(\App\DemoCaseStudy::class);
    }

    /**
     * Get the directories for the country.
     */
    public function directories()
    {
        return $this->hasMany(\App\Directory::class);
    }

    /**
     * Get the events for the country.
     */
    public function events()
    {
        return $this->hasMany(\App\Event::class);
    }

    /**
     * Get the media library for the country.
     */
    public function mediaLibrary()
    {
        return $this->hasMany(\App\MediaLibrary::class);
    }

    /**
     * Get the news for the country.
     */
    public function news()
    {
        return $this->hasMany(\App\News::class);
    }
}
