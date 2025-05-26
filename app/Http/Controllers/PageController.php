<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;

class PageController extends Controller
{
    /**
     * Show the legal notice.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function legalNotice()
    {
        return view('page.legal-notice.' . strtolower(locale(true)));
    }

    /**
     * Show the cookies policy.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cookiesPolicy()
    {
        $consent = json_decode(request()->cookie('cc_cookie'), true);

        $types = [];
        $map = [
            'necessary' => __('necesarias'),
        ];

        if (empty(!$consent)) {
            $types = array_map(function ($item) use ($map) {
                return $map[$item];
            }, $consent['level']);
        }

        return view('page.cookies-policy.' . strtolower(locale(true)), compact('consent', 'types'));
    }

    /**
     * Show the privacy policy.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function privacyPolicy()
    {
        return view('page.privacy-policy.' . strtolower(locale(true)));
    }

    /**
     * Show the terms.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function terms()
    {
        return view('page.terms.' . strtolower(locale(true)));
    }
}
