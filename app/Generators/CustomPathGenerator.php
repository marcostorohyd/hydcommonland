<?php

namespace App\Generators;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\BasePathGenerator;

class CustomPathGenerator extends BasePathGenerator
{
    /*
     * Get a unique base path for the given media.
     */
    protected function getBasePath(Media $media): string
    {
        // Get model name
        $array = explode('\\', $media->model_type);
        $model = strtolower(array_pop($array));

        return $model.'/'.$media->model_id.'/'.$media->collection_name.'/'.$media->getKey();
    }
}
