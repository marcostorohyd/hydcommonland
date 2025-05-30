<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Format extends Model
{
    use SoftDeletes;
    use Translatable;

    /**
     * ID for video.
     *
     * @var int
     */
    const VIDEO = 1;

    /**
     * ID for gallery.
     *
     * @var int
     */
    const GALLERY = 2;

    /**
     * ID for presentation.
     *
     * @var int
     */
    const PRESENTATION = 3;

    /**
     * ID for document.
     *
     * @var int
     */
    const DOCUMENT = 4;

    /**
     * ID for audio.
     *
     * @var int
     */
    const AUDIO = 5;

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
        'color',
        'media_collection',
        'created_by_id',
        'updated_by_id',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];
}
