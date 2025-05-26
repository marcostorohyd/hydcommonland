<?php

namespace App\Generators;

use Spatie\MediaLibrary\UrlGenerator\LocalUrlGenerator;
use Spatie\MediaLibrary\Exceptions\UrlCannotBeDetermined;
use App\Config;

class CustomUrlGenerator extends LocalUrlGenerator
{
    protected function getBaseMediaDirectoryUrl(): string
    {
        if ($diskUrl = Config::url() . '/storage') {
            return $diskUrl;
        }

        if (! starts_with($this->getStoragePath(), public_path())) {
            throw UrlCannotBeDetermined::mediaNotPubliclyAvailable($this->getStoragePath(), public_path());
        }

        return $this->getBaseMediaDirectory();
    }

    /**
     * Get the url for a media item.
     *
     * @return string
     *
     * @throws \Spatie\MediaLibrary\Exceptions\UrlCannotBeDetermined
     */
    public function getUrl(): string
    {
        if ('local' == $this->media->disk) {
            $url = Config::url().'/image/'.$this->media->id;
        } else {
            $url = $this->getBaseMediaDirectoryUrl().'/'.$this->getPathRelativeToRoot();
        }

        $url = $this->makeCompatibleForNonUnixHosts($url);

        $url = $this->rawUrlEncodeFilename($url);

        return $url;
    }
}
