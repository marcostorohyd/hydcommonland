<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use SoftDeletes;
    use Translatable;

    /**
     * The id of person.
     */
    const PERSON = 1;

    /**
     * The id of community.
     */
    const COMMUNITY = 4;

    /**
     * The id of indigenous people.
     */
    const INDIGENOUS_PEOPLE = 8;

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
        'updated_by_id',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];
}
