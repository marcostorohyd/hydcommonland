<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Change language
     *
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
