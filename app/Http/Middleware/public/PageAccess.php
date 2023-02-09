<?php

namespace App\Http\Middleware\public;

use Closure;
use Illuminate\Http\Request;

class PageAccess
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
        //check OTP page access
        $access = $request->input('access');
        if ($access != 'granted') {
            return redirect()->route('client.forgotPassword');
        }
        return $next($request);
    }
}
