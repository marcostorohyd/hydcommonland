<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DirectoryChange extends Model
{
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
        'id',
        'name',
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
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * Get the country that owns the directory change.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the directory that owns the directory change.
     */
    public function directory()
    {
        return $this->belongsTo(Directory::class, 'id');
    }

    /**
     * Get the entity that owns the directory change.
     */
    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    /**
     * The sectors that belong to the directory change.
     */
    public function sectors()
    {
        return $this->belongsToMany(Sector::class);
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
        return Storage::url("public/directory-change/{$this->id}/{$this->image}");
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
