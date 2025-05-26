<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;

class Tag extends Model
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
        'created_by_id',
        'updated_by_id'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * Get the media library for the tag.
     */
    public function mediaLibrary()
    {
        return $this->hasMany('App\MediaLibrary');
    }
}
