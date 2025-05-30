<?php

// namespace App\Helpers;

if (! function_exists('locale')) {
    /**
     * Get the locale
     *
     * @return mixed
     */
    function locale(bool $humanize = false)
    {
        $locale = \Illuminate\Support\Facades\App::getLocale();
        $locales = locales($humanize);

        if ($humanize) {
            if (array_key_exists($locale, $locales)) {
                return $locales[$locale];
            }
        } else {
            if (in_array($locale, $locales)) {
                return $locale;
            }
        }

        return false;
    }
}

if (! function_exists('locales')) {
    /**
     * Get the locales
     *
     * @return array
     */
    function locales(bool $humanize = false, string $flag = ARRAY_FILTER_USE_BOTH, ?Closure $closure = null)
    {
        $locales = [];

        foreach (config('translatable.locales') as $lang => $value) {
            if (! is_array($value)) {
                $locales[] = $value;
            } else {
                foreach ($value as $sub) {
                    $locales[] = $lang.'-'.$sub;
                }
            }
        }

        if ($humanize) {
            $locales = array_combine($locales, array_map(function ($item) {
                $pos = strpos($item, '-');
                if ($pos !== false) {
                    return strtoupper(substr($item, 0, $pos));
                } else {
                    return strtoupper($item);
                }
            }, $locales));
        }

        if ($flag == ARRAY_FILTER_USE_KEY) {
            $locales = array_keys($locales);
        }

        if (! empty($closure)) {
            $locales = array_map($closure, $locales);
        }

        return $locales;
    }
}

if (! function_exists('locales_except')) {
    /**
     * Get the locales except array
     *
     * @param  mixed  $except  Array or String
     * @param  string  $suffix
     * @return array
     */
    function locales_except($lang = [], $suffix = '')
    {
        if (! is_array($lang)) {
            $lang = [$lang];
        }

        return array_map(function ($item) use ($suffix) {
            return $item.$suffix;
        }, array_filter(locales(), function ($item) use ($lang) {
            return ! in_array($item, $lang);
        }));
    }
}
