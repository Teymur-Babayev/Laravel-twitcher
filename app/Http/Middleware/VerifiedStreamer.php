<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifiedStreamer
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
        if ($request->user() && $request->user()->is_streamer == 'yes' && $request->user()->is_streamer_verified == 'no') {
            if (!in_array($request->route()->getName(), ['streamer.verify', 'streamer.submitVerification', 'streamer.pendingVerification', 'logout'])) {
                if ($request->user()->streamer_verification_sent == 'yes') {
                    return to_route('streamer.pendingVerification');
                } else {
                    return to_route('streamer.verify');
                }
            }
        }
        return $next($request);
    }
}
