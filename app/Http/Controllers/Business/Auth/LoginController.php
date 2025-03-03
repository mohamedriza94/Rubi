<?php

namespace App\Http\Controllers\Business\Auth;

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
    protected $redirectTo = RouteServiceProvider::BUSINESS;
    
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('guest:business')->except('logout');
    }
    
    /**
    * Get the guard to be used during authentication.
    *
    * @return \Illuminate\Contracts\Auth\StatefulGuard
    */
    protected function guard()
    {
        return Auth::guard('business');
    }
    
    /**
    * Show the application's login form.
    *
    * @return \Illuminate\Http\Response
    */
    public function showLoginForm()
    {
        $view_data['title'] = 'Signin';
        return view('client.signin', $view_data);
    }
    
    public function validateLogin(Request $request)
    {
        // Attempt to log the user in
        if ($this->guard()->attempt(['email' => $request->email, 
        'password' => $request->password, 'status' => 'active'])) {
            
            //Record Activity
            $data = [ 'userType' => 'business', 'activity' => 'Logged In', 
            'user' => auth()->guard('business')->user()->id ];
            $activityController = new \App\Http\Controllers\common\ActivityController;
            $activityController->recordActivity($data);
            
            return redirect()->intended(route('business.dashboard'));
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
        : redirect()->route('business.dashboard'));
    }
    
    /**
    * Log the user out of the application.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function logout(Request $request)
    {
        $userData = auth()->guard('business')->user()->id;
        
        $this->guard()->logout();
        Session::flush();
        $request->session()->regenerate(true);
        
        //Record Activity
        $data = [ 'userType' => 'business', 'activity' => 'Logged Out', 
        'user' => $userData];
        $activityController = new \App\Http\Controllers\common\ActivityController;
        $activityController->recordActivity($data);

        return redirect()->route('business.login');
    }
}
