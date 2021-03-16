<?php

namespace App\Http\Middleware;

use App\Utils\Config;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(
            parent::share($request),
            [
                'config' => Config::getConfig(),
                'flash' => [
                    'info' => fn () => $request->session()->get('info'),
                    'success' => fn () => $request->session()->get('success'),
                    'warning' => fn () => $request->session()->get('warning'),
                    'error' => fn () => $request->session()->get('error'),
                ],
            ]
        );
    }
}
