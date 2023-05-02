<?php

namespace App\Http\Controllers\Sub\Auth;

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
    protected $redirectTo = RouteServiceProvider::BUSINESSADMIN;
    
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('guest:businessAdmin')->except('logout');
    }
    
    /**
    * Get the guard to be used during authentication.
    *
    * @return \Illuminate\Contracts\Auth\StatefulGuard
    */
    protected function guard()
    {
        return Auth::guard('businessAdmin');
    }
    
    /**
    * Show the application's login form.
    *
    * @return \Illuminate\Http\Response
    */
    public function showLoginForm()
    {
        $view_data['title'] = 'Login';
        $view_data['brand'] = 'Business';
        return view('sub.auth.login', $view_data);
    }
    
    public function validateLogin(Request $request)
    {
        // Attempt to log the user in
        if ($this->guard()->attempt(['email' => $request->email, 
        'password' => $request->password])) {

            $userData = auth()->guard('businessAdmin')->user();
            //record attendance
            if($userData->role == 'employee')
            {
                $data = [ 'business' => $userData->business, 'department' => $userData->department, 
                'employee' => $userData->id ];
                
                $activityController = new \App\Http\Controllers\sub\AttendanceController;
                $activityController->recordAttendance($data);
            }
            
            //Record Activity
            $userID = $userData->id;
            $userRole = $userData->role;
            
            $data = [ 'userType' => $userRole, 'activity' => 'Logged In', 
            'user' => $userID ];
            
            $activityController = new \App\Http\Controllers\common\ActivityController;
            $activityController->recordActivity($data);
            
            return redirect()->intended(route('sub.dashboard'));
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
        : redirect()->route('sub.dashboard'));
    }
    
    /**
    * Log the user out of the application.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function logout(Request $request)
    {
        $userID = auth()->guard('businessAdmin')->user()->id;
        $userRole = auth()->guard('businessAdmin')->user()->role;
        
        $this->guard()->logout();
        Session::flush();
        $request->session()->regenerate(true);
        
        //Record Activity
        $data = [ 'userType' => $userRole, 'activity' => 'Logged Out', 
        'user' => $userID];
        $activityController = new \App\Http\Controllers\common\ActivityController;
        $activityController->recordActivity($data);

        return redirect()->route('sub.login');
    }
}

