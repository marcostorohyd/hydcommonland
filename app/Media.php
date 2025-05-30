<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    /**
     * Max file size in KB.
     *
     * @var string
     */
    const FILE_MAX_SIZE = 20000;

    /**
     * Allowed file mimes.
     *
     * @var string
     */
    const FILE_ALLOWED = '.pdf,.ppt,.pptx,.doc,.docx,.mp3';

    /**
     * Max image size in KB.
     *
     * @var string
     */
    const IMAGE_MAX_SIZE = 3000;

    /**
     * Allowed image types.
     *
     * @var string
     */
    const IMAGE_ALLOWED = '.jpg,.png,.jpeg';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order_column', 'asc');
        });
    }

    /**
     * Return humanize format
     *
     * @return void
     */
    public static function humanize(string $type)
    {
        return str_replace('.', '', str_replace(',', ', ', $type));
    }
}
