<?php

namespace App\Http\Controllers\Sub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;

class PathController extends Controller
{
    private $brand;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $usersBusiness = Auth::guard('businessAdmin')->user()->business;
            $business = Business::find($usersBusiness);
            $this->brand = $business->name;
            return $next($request);
        });
    }

    public function dashboard()
    {
        if(auth()->guard('businessAdmin')->user()->role=="admin")
        {
            $view_data['title'] = 'Admin Dashboard'; $view_data['brand'] = $this->brand;
            return view('sub.dashboard.adminIndex')->with($view_data);
        }
        else 
        {
            $view_data['title'] = 'Employee Dashboard'; $view_data['brand'] = $this->brand;
            return view('sub.dashboard.employeeIndex')->with($view_data);
        }
    }
}
