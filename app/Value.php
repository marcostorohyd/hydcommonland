<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;

class Value extends Model
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
        'color',
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
     * Get image path.
     *
     * @return string
     */
    public function imageUrl()
    {
        return url("/svg/values/{$this->id}.svg");
    }

    /**
     * Get image path.
     *
     * @return string
     */
    public function imageMiniUrl()
    {
        return url("/svg/values/{$this->id}-mini.svg");
    }
}
