<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;
    use Translatable;

    /**
     * Status approved.
     *
     * @var int
     */
    const APPROVED = 2;

    /**
     * Status pending.
     *
     * @var int
     */
    const PENDING = 1;

    /**
     * Status refused.
     *
     * @var int
     */
    const REFUSED = 3;

    /**
     * Status changed.
     *
     * @var int
     */
    const CHANGE_REQUEST = 4;

    /**
     * The attributes for translation.
     *
     * @var array
     */
    public $translatedAttributes = ['name'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->order();
        });
    }

    /**
     * Scope a query to order.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrder($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order',
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
