<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Directory extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;

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
        'status_id',
        'user_id',
        'email',
        'phone',
        'address',
        'zipcode',
        'city',
        'country_id',
        'latitude',
        'longitude',
        'entity_id',
        'contact_name',
        'contact_email',
        'contact_phone',
        'partners',
        'members',
        'represented',
        'surface',
        'image',
        'web',
        'facebook',
        'linkedin',
        'research_gate',
        'instagram',
        'twitter',
        'youtube',
        'vimeo',
        'tiktok',
        'whatsapp',
        'telegram',
        'orcid',
        'academia_edu',
        'created_by_id',
        'updated_by_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name_with_status'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations', 'status'];

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
            static::addGlobalScope('visible', function (Builder $builder) {
                $builder->approved();
            });
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
        return $query->whereIn('status_id', [Status::APPROVED, Status::CHANGE_REQUEST]);
    }

    /**
     * Get the directory's name and status.
     *
     * @return string
     */
    public function getNameWithStatusAttribute()
    {
        if ($this->status_id != Status::APPROVED) {
            return "{$this->name} ({$this->status->name})";
        }

        return $this->name;
    }

    /**
     * Query
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function filter(Builder $query, \Illuminate\Http\Request $request)
    {
        if (! empty($search = $request->get('entity_id'))) {
            $query->whereIn('entity_id', $search);
        }
        if (! empty($search = $request->get('country_id'))) {
            $query->whereIn('country_id', $search);
        }
        if (! empty($search = $request->get('sector_id'))) {
            $query->whereHas('sectors', function ($query) use ($search) {
                $query->whereIn('directory_sector.sector_id', $search);
            });
        }

        return $query;
    }

    /**
     * Get the change that owns the directory.
     */
    public function change()
    {
        return $this->hasOne(DirectoryChange::class, 'id');
    }

    /**
     * Get the country that owns the directory.
     */
    public function country()
    {
        return $this->belongsTo(\App\Country::class);
    }

    /**
     * Get the entity that owns the directory.
     */
    public function entity()
    {
        return $this->belongsTo(\App\Entity::class);
    }

    /**
     * The sectors that belong to the directory.
     */
    public function sectors()
    {
        return $this->belongsToMany(\App\Sector::class);
    }

    /**
     * Get the user that owns the directory.
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * Get the status that owns the directory.
     */
    public function status()
    {
        return $this->belongsTo(\App\Status::class);
    }

    /**
     * Get full address.
     *
     * @return string
     */
    public function fullAddress()
    {
        $address = [];
        if (! empty($this->address)) {
            $address[] = $this->address;
        }

        $address[] = $this->zipcode;
        $address[] = $this->city;

        return implode(' ', $address).' - '.$this->country->name;
    }

    /**
     * Check if it has surface
     *
     * @return bool
     */
    public function hasSurface()
    {
        return in_array($this->entity_id, [Entity::COMMUNITY, Entity::INDIGENOUS_PEOPLE]);
    }

    /**
     * Get image path.
     *
     * @return string
     */
    public function imageUrl()
    {
        return Storage::url("public/directory/{$this->id}/{$this->image}");
    }

    /**
     * Get all social attributes.
     *
     * @return array
     */
    public static function socialAttributes()
    {
        return [
            'facebook',
            'linkedin',
            'research_gate',
            'instagram',
            'twitter',
            'youtube',
            'vimeo',
            'tiktok',
            'whatsapp',
            'telegram',
            'orcid',
            'academia_edu',
        ];
    }

    /**
     * Has social attributes.
     *
     * @return bool
     */
    public function hasSocialAttributes()
    {
        $socialAttributes = self::socialAttributes();

        foreach ($socialAttributes as $item) {
            if (! empty($this->{$item})) {
                return true;
            }
        }

        return false;
    }
}
