<?php

namespace App\Http\Controllers\Rubi\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    
    /**
    * Where to redirect users after login.
    *
    * @var string
    */
    protected $redirectTo = RouteServiceProvider::RUBIADMIN;
    
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('guest:rubiAdmin')->except('logout');
    }
    
    /**
    * Get the guard to be used during authentication.
    *
    * @return \Illuminate\Contracts\Auth\StatefulGuard
    */
    protected function guard()
    {
        return Auth::guard('rubiAdmin');
    }
    
    /**
    * Show the application's login form.
    *
    * @return \Illuminate\Http\Response
    */
    public function showLoginForm()
    {
        $view_data['title'] = 'Login'; $view_data['brand'] = 'Rubi';
        return view('rubi.auth.login', $view_data);
    }
    
    public function validateLogin(Request $request)
    {
        // Attempt to log the user in
        if ($this->guard()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended(route('rubi.dashboard'));
        } 
        
        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email'))->withErrors([
            'password' => 'Invalid Email or Password!'
        ]);
    }
    
    protected function redirectPath()
    {
        return method_exists($this, 'redirectTo')
        ? $this->redirectTo()
        : (property_exists($this, 'redirectToRoute')
        ? redirect()->route($this->redirectToRoute)
        : redirect()->route('rubi.dashboard'));
    }
    
    // protected function redirectPath()
    // {
        //     if (method_exists($this, 'redirectTo')) {
            //         return $this->redirectTo();
            //     }
            //     return property_exists($this, 'redirectTo') ? $this->redirectTo : '/rubi/dashboard';
            // }
            
            
            
            
            /**
            * Log the user out of the application.
            *
            * @param  \Illuminate\Http\Request  $request
            * @return \Illuminate\Http\Response
            */
            public function logout(Request $request)
            {
                $this->guard()->logout();
                Session::flush();
                $request->session()->regenerate(true);
                return redirect()->route('rubi.login');
            }
        }
        