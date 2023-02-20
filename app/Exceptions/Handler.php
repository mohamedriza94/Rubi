<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;
use Exception;
use Request;
use Response;

class Handler extends ExceptionHandler
{
    protected $levels = [
        //
    ];
    
    protected $dontReport = [
        //
    ];
    
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];
    
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        $guard = \Arr::get($exception->guards(), 0);

        switch ($guard) {
            case 'rubiAdmin': $login = 'rubi.login'; break;
            case 'business': $login = 'business.login'; break;
            
            // default:
            //     $login = 'login';
            //     break;
        }
        return redirect()->guest(route($login));
    }
}
