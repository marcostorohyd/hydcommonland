<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class DemoCaseStudy extends Model
{
    use HasFactory;
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
        'date',
        'address',
        'country_id',
        'link',
        'link2',
        'link3',
        'link4',
        'link5',
        'email',
        'image',
        'condition_id',
        'status_id',
        'created_by_id',
        'updated_by_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
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
        if (empty($route) || $route->getPrefix() !== '/backend') {
            static::addGlobalScope('approved', function (Builder $builder) {
                $builder->date()
                    ->approved();
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
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status_id', Status::APPROVED);
    }

    /**
     * Scope a query to order by date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDate($query)
    {
        return $query->orderBy('date', 'desc')
            ->orderBy('id', 'desc');
    }

    /**
     * Scope a query to only include no admin users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMe($query)
    {
        return $query->where('demo_case_studies.created_by_id', auth()->user()->id);
    }

    /**
     * Query
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
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
        if (! empty($search = $request->get('condition_id'))) {
            if (is_array($search)) {
                $query->whereIn('condition_id', $search);
            } else {
                $query->where('condition_id', $search);
            }
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
                $query->where('demo_case_study_sector.sector_id', $search);
            });
        }
        if (! empty($search = $request->get('sector_id'))) {
            $query->whereHas('sectors', function ($query) use ($search) {
                $query->whereIn('demo_case_study_sector.sector_id', $search);
            });
        }
        if (! empty($search = $request->get('value_id'))) {
            $query->whereHas('values', function ($query) use ($search) {
                $query->whereIn('demo_case_study_value.value_id', $search)
                    ->groupBy('demo_case_study_id')
                    ->havingRaw('count(demo_case_study_id) = '.count($search));
            });
        }
        if (! is_null($search = $request->get('status_id'))) {
            $query->where('status_id', $search);
        }

        return $query;
    }

    /**
     * Get the country that owns the demo case study.
     */
    public function country()
    {
        return $this->belongsTo(\App\Country::class);
    }

    /**
     * The values that belong to the demo case study.
     */
    public function values()
    {
        return $this->belongsToMany(\App\Value::class);
    }

    /**
     * The sectors that belong to the demo case study.
     */
    public function sectors()
    {
        return $this->belongsToMany(\App\Sector::class);
    }

    /**
     * Get the status that owns the demo case study.
     */
    public function status()
    {
        return $this->belongsTo(\App\Status::class);
    }

    /**
     * Get image path.
     *
     * @return string
     */
    public function imageUrl()
    {
        return Storage::url("public/demo/{$this->id}/{$this->image}");
    }
}
