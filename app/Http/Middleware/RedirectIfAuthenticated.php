<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
    * @param  string|null  ...$guards
    * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        
        foreach ($guards as $guard) {
            switch ($guard) {
                case 'rubiAdmin':
                    if (Auth::guard($guard)->check()) 
                    {
                        return redirect()->route('rubi.dashboard'); //if rubi admin is authenticated, redirect to rubi dashboard
                    }
                    break;
                
                    case 'business':
                        if (Auth::guard($guard)->check()) 
                        {
                            return redirect()->route('business.dashboard'); //if business is authenticated, redirect to business dashboard
                        }
                        break;
                
                        case 'businessAdmin':
                            if (Auth::guard($guard)->check()) 
                            {
                                return redirect()->route('sub.dashboard'); //if user is authenticated, redirect to business dashboard
                            }
                            break;
                    
                    // default:
                    //     if (Auth::guard($guard)->check()) {
                        //         return redirect('/dashboard');
                        //     }
                        //     break;
                    }
                }
                
                return $next($request);
            }
        }
        