<?php

namespace App;

class Tool
{
    /**
     * Convert data to dropzone
     *
     * @param mixed $items
     * @return array
     */
    public static function toDropzone($items = null)
    {
        $is_collection = is_a($items, 'Illuminate\Database\Eloquent\Collection');
        if (($is_collection && ! $items->count()) || empty($items)) {
            return [];
        }

        $files = [];
        foreach ($items as $item) {
            $files[] = [
                'name' => $is_collection ? $item->file_name : $item,
                'thumbnail' => $is_collection ? self::mimeToUrl($item->getUrl(), $item->mime_type) : $item,
                'size' => $is_collection ? $item->size : 0,
                'type' => $is_collection ? $item->mime_type : '',
                'serverID' => $is_collection ? $item->id : uniqid(),
                'accepted' => true
            ];
        }

        return $files;
    }

    /**
     * Return url
     *
     * @param string $url
     * @param string $mime
     * @return string
     */
    public static function mimeToUrl(string $url, string $mime)
    {
        if (false !== strpos($mime, 'image/')) {
            return $url;
        }

        switch ($mime) {
            case 'application/pdf':
                return url('/svg/files/pdf.svg');
                break;

            case 'application/msword':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            case 'application/vnd.oasis.opendocument.text':
                return url('/svg/files/word.svg');
                break;

            case 'application/vnd.ms-powerpoint':
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
            case 'application/vnd.oasis.opendocument.presentation':
                return url('/svg/files/powerpoint.svg');
                break;

            case 'audio/mpeg':
                return url('/svg/files/audio.svg');
                break;

            default:
                return url('/svg/files/file.svg');
                break;
        }
    }
}
