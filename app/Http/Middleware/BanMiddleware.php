<?php

namespace App\Http\Middleware;

use App\Models\Banned;
use Closure;
use Illuminate\Http\Request;

class BanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // check banned ip's
        if (Banned::where('ip', $request->ip())->exists() and $request->route()->getName() != 'banned-ip') {
            return redirect(route('banned-ip'));
            exit;
        }


        // update ip
        if ($request->user()) {
            if (!$request->user()->ip) {
                $request->user()->update(['ip' => $request->ip()]);
            }
        }

        return $next($request);
    }
}
