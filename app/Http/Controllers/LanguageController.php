<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Change language
     *
     * @param string $lang
     * @return void
     */
    public function switchLang(string $lang)
    {
        if (in_array($lang, locales())) {
            Session::put('applocale', $lang);
        }

        return redirect()->back();
    }
}
