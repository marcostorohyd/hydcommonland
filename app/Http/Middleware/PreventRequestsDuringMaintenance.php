<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    // /**
    //  * Handle an incoming request.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \Closure  $next
    //  * @return mixed
    //  *
    //  * @throws \Symfony\Component\HttpKernel\Exception\HttpException
    //  */
    // public function handle($request, Closure $next)
    // {
    //     if ($this->app->isDownForMaintenance()) {
    //         $data = json_decode(file_get_contents($this->app->storagePath().'/framework/down'), true);

    //         if (isset($data['allowed']) && IpUtils::checkIp($request->ip(), (array) $data['allowed'])) {
    //             return $next($request);
    //         }

    //         if ($this->inExceptArray($request)) {
    //             return $next($request);
    //         }

    //         if ($request->has('dev_mode') || $request->hasCookie('dev_mode')) {
    //             Cookie::queue('dev_mode', true, 60*24*365);
    //             return $next($request);
    //         }

    //         throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
    //     }

    //     return $next($request);
    // }
}
