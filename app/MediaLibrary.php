<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class MediaLibrary extends Model implements HasMedia
{
    use HasFactory;
    use HasMediaTrait;
    use SoftDeletes;

    /**
     * Allowed file types.
     *
     * @var string
     */
    const AUDIO_ALLOWED = '.mp3';

    /**
     * Max number of audios.
     *
     * @var int
     */
    const AUDIO_MAX_FILES = 1;

    /**
     * Max file size in KB.
     *
     * @var string
     */
    const AUDIO_MAX_SIZE = 20000;

    /**
     * Allowed file types.
     *
     * @var string
     */
    const DOCUMENT_ALLOWED = '.pdf';

    /**
     * Max number of documents.
     *
     * @var int
     */
    const DOCUMENT_MAX_FILES = 1;

    /**
     * Max file size in KB.
     *
     * @var string
     */
    const DOCUMENT_MAX_SIZE = 20000;

    /**
     * Max number of images for gallery.
     *
     * @var int
     */
    const GALLERY_MAX_FILES = 10;

    /**
     * Max file size in KB.
     *
     * @var string
     */
    const IMAGE_MAX_SIZE = 3000;

    /**
     * Allowed file types.
     *
     * @var string
     */
    const IMAGE_ALLOWED = '.jpg,.png,.jpeg';

    /**
     * Allowed file types.
     *
     * @var string
     */
    const PRESENTATION_ALLOWED = '.ppt,.pptx';

    /**
     * Max number of presentations.
     *
     * @var int
     */
    const PRESENTATION_MAX_FILES = 1;

    /**
     * Max file size in KB.
     *
     * @var string
     */
    const PRESENTATION_MAX_SIZE = 20000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'date',
        'country_id',
        'author',
        'email',
        'image',
        'format_id',
        'external',
        'link',
        'length',
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
        return $query->orderBy('date', 'desc');
    }

    /**
     * Scope a query to only include no admin users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMe($query)
    {
        return $query->where('media_libraries.created_by_id', auth()->user()->id);
    }

    /**
     * Query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function filter(Builder $query, \Illuminate\Http\Request $request)
    {
        if (! empty($search = $request->get('name'))) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
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
        if (! empty($search = $request->get('format_id'))) {
            if (is_array($search)) {
                $query->whereIn('format_id', $search);
            } else {
                $query->where('format_id', $search);
            }
        }
        if (! empty($search = $request->get('sectors'))) {
            $query->whereHas('sectors', function ($query) use ($search) {
                $query->where('media_library_sector.sector_id', $search);
            });
        }
        if (! empty($search = $request->get('sector_id'))) {
            $query->whereHas('sectors', function ($query) use ($search) {
                $query->whereIn('media_library_sector.sector_id', $search);
            });
        }
        if (! empty($search = $request->get('tags'))) {
            $query->whereHas('tags', function ($query) use ($search) {
                $query->where('media_library_tag.tag_id', $search);
            });
        }
        if (! empty($search = $request->get('tag_id'))) {
            $query->whereHas('tags', function ($query) use ($search) {
                $query->whereIn('media_library_tag.tag_id', $search);
            });
        }
        if (! is_null($search = $request->get('format_id'))) {
            $query->where('format_id', $search);
        }
        if (! is_null($search = $request->get('status_id'))) {
            $query->where('status_id', $search);
        }

        return $query;
    }

    /**
     * Get the country that owns the media library.
     */
    public function country()
    {
        return $this->belongsTo(\App\Country::class);
    }

    /**
     * Get the format that owns the media library.
     */
    public function format()
    {
        return $this->belongsTo(\App\Format::class);
    }

    /**
     * The sectors that belong to the media library.
     */
    public function sectors()
    {
        return $this->belongsToMany(\App\Sector::class);
    }

    /**
     * Get the status that owns the media library.
     */
    public function status()
    {
        return $this->belongsTo(\App\Status::class);
    }

    /**
     * The tags that belong to the media library.
     */
    public function tags()
    {
        return $this->belongsToMany(\App\Tag::class);
    }

    /**
     * Get info
     *
     * @return string
     */
    public function info(?Media $media = null)
    {
        switch ($this->format_id) {
            case Format::VIDEO:
            case Format::AUDIO:
                return $this->length ? $this->length.'´' : '';
                break;

            case Format::GALLERY:
                if (empty($media)) {
                    return '';
                }

                return $media->human_readable_size ?? '';
                break;

            case Format::PRESENTATION:
                $media = $this->getFirstMedia($this->format->media_collection);

                return $media->human_readable_size ?? '';
                break;

            case Format::DOCUMENT:
                if (empty($this->length)) {
                    return '';
                }

                return $this->length.' '.($this->length > 1 ? __('messages.páginas') : __('messages.página'));
                break;

            default:
                return '';
                break;
        }
    }

    /**
     * Get image path.
     *
     * @return string
     */
    public function imageUrl()
    {
        return Storage::url("public/medialibrary/{$this->id}/{$this->image}");
    }

    /**
     * Return if it is downloadable
     *
     * @return bool
     */
    public function isDownloadable()
    {
        $items = [Format::AUDIO, Format::DOCUMENT, Format::GALLERY, Format::PRESENTATION];

        if (in_array($this->format_id, $items) || ! empty($this->external)) {
            return true;
        }

        return false;
    }

    /**
     * Return if it is compatible wieth the viewer
     *
     * @return bool
     */
    public function hasViewerCompatibility()
    {
        $items = [Format::AUDIO, Format::DOCUMENT, Format::PRESENTATION];

        if (! in_array($this->format_id, $items)) {
            return false;
        }

        if ($this->external) {
            switch ($this->format_id) {
                case Format::AUDIO:
                    $exts = explode(',', self::AUDIO_ALLOWED);
                    break;

                case Format::PRESENTATION:
                    $exts = explode(',', self::PRESENTATION_ALLOWED);
                    break;

                case Format::DOCUMENT:
                    $exts = explode(',', self::DOCUMENT_ALLOWED);
                    break;
            }

            return in_array(substr($this->link, -4), $exts);
        }

        return true;
    }

    /**
     * Get url for viewer.
     *
     * @return string
     */
    public function viewerUrl()
    {
        if ($this->external) {
            return $this->link;
        }

        return $this->getFirstMedia($this->format->media_collection)->getFullUrl();
    }
}
