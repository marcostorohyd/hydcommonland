<?php

namespace App\Generators;

use App\Config;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Exceptions\UrlCannotBeDetermined;
use Spatie\MediaLibrary\UrlGenerator\LocalUrlGenerator;

class CustomUrlGenerator extends LocalUrlGenerator
{
    protected function getBaseMediaDirectoryUrl(): string
    {
        if ($diskUrl = Config::url().'/storage') {
            return $diskUrl;
        }

        if (! Str::startsWith($this->getStoragePath(), public_path())) {
            throw UrlCannotBeDetermined::mediaNotPubliclyAvailable($this->getStoragePath(), public_path());
        }

        return $this->getBaseMediaDirectory();
    }

    /**
     * Get the url for a media item.
     *
     *
     * @throws \Spatie\MediaLibrary\Exceptions\UrlCannotBeDetermined
     */
    public function getUrl(): string
    {
        if ($this->media->disk == 'local') {
            $url = Config::url().'/image/'.$this->media->id;
        } else {
            $url = $this->getBaseMediaDirectoryUrl().'/'.$this->getPathRelativeToRoot();
        }

        $url = $this->makeCompatibleForNonUnixHosts($url);

        $url = $this->rawUrlEncodeFilename($url);

        return $url;
    }
}
