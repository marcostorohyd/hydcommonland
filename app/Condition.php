<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;

class Condition extends Model
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
     * Get the demo case studies for the condition.
     */
    public function demos()
    {
        return $this->hasMany(\App\DemoCaseStudy::class);
    }
}
