<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Dimsav\Translatable\Translatable;

class Event extends Model
{
    use SoftDeletes;
    use Translatable;

    /**
     * Max file size in KB.
     *
     * @var string
     */
    const IMAGE_MAX_SIZE = 2000;

    /**
     * Allowed file types.
     *
     * @var string
     */
    const IMAGE_ALLOWED = '.jpg,.png,.jpeg';

    /**
     * The attributes for translation.
     *
     * @var array
     */
    public $translatedAttributes = ['description'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'start',
        'end',
        'register_url',
        'assistance_id',
        'type_id',
        'language',
        'venue_name',
        'venue_address',
        'country_id',
        'image',
        'status_id',
        'created_by_id',
        'updated_by_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        $route = request()->route();
        if (empty($route) || '/backend' !== $route->getPrefix()) {
            static::addGlobalScope('approved', function (Builder $builder) {
                $builder->approved();
            });
        } else {
            $user = auth()->user();
            if (! $user->isAdmin()) {
                static::addGlobalScope('me', function (Builder $builder) {
                    $builder->me();
                });
            }
        }
    }

    /**
     * Scope a query to only include admin users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status_id', Status::APPROVED);
    }

    /**
     * Scope a query to only include no admin users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMe($query)
    {
        return $query->where('events.created_by_id', auth()->user()->id);
    }

    /**
     * Query
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function filter(Builder $query, \Illuminate\Http\Request $request)
    {
        if (! empty($search = $request->get('name'))) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            });
        }
        if (! empty($search = $request->get('country_id'))) {
            if (is_array($search)) {
                $query->whereIn('country_id', $search);
            } else {
                $query->where('country_id', $search);
            }
        }
        if (! empty($search = $request->get('sectors'))) {
            $query->whereHas('sectors', function ($query) use ($search) {
                $query->where('event_sector.sector_id', $search);
            });
        }
        if (! empty($search = $request->get('sector_id'))) {
            $query->whereHas('sectors', function ($query) use ($search) {
                $query->whereIn('event_sector.sector_id', $search);
            });
        }
        if (! is_null($search = $request->get('status_id'))) {
            $query->where('status_id', $search);
        }
        if (! is_null($search = $request->get('type_id'))) {
            if (is_array($search)) {
                $query->whereIn('type_id', $search);
            } else {
                $query->where('type_id', $search);
            }
        }

        return $query;
    }

    /**
     * Get the assistance that owns the event.
     */
    public function assitance()
    {
        return $this->belongsTo(\App\EventAssistance::class);
    }

    /**
     * Get the country that owns the event.
     */
    public function country()
    {
        return $this->belongsTo(\App\Country::class);
    }

    /**
     * The sectors that belong to the event.
     */
    public function sectors()
    {
        return $this->belongsToMany(\App\Sector::class);
    }

    /**
     * Get the status that owns the event.
     */
    public function status()
    {
        return $this->belongsTo(\App\Status::class);
    }

    /**
     * Get the type that owns the event.
     */
    public function type()
    {
        return $this->belongsTo(\App\EventType::class);
    }

    /**
     * Get image path.
     *
     * @return string
     */
    public function imageUrl()
    {
        return Storage::url("public/event/{$this->id}/{$this->image}");
    }
}
