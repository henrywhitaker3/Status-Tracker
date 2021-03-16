<?php

namespace App\Http\Middleware;

use Closure;

class RememberQueryStrings
{
    public function handle($request, Closure $next)
    {
        if ($request->wantsJson()) {
            return $next($request);
        }

        if (empty($request->all())) {
            return $this->remembered($next, $request);
        }

        if ($request->get('remember') === 'no') {
            return $next($request);
        }

        if ($request->get('remember') === 'forget') {
            return $this->forget($next, $request);
        }

        return $this->remember($next, $request);
    }

    protected function remembered($next, $request)
    {
        $remembered = array_filter($request->session()->get($this->getSessionKey($request)) ?? []);

        if ($remembered) {
            $request->session()->reflash();

            return redirect(url($request->path()) . '?' . http_build_query($remembered));
        }

        return $next($request);
    }

    protected function remember($next, $request)
    {
        $request->session()->put(
            $this->getSessionKey($request),
            array_filter($request->all())
        );

        return $next($request);
    }

    protected function forget($next, $request)
    {
        $request->session()->remove($this->getSessionKey($request));

        return redirect(url($request->path()));
    }

    private function getSessionKey($request)
    {
        return 'remember_query_strings.' . $request->route()->getName() . $request->path();
    }
}
