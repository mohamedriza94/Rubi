<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PathController extends Controller
{
    private $brand;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->brand = Auth::guard('business')->user()->name;
            return $next($request);
        });
    }

    public function dashboard()
    {
        $view_data['title'] = 'Dashboard'; $view_data['brand'] = $this->brand;
        return view('business.dashboard.index')->with($view_data);
    }

    public function departments()
    {
        $view_data['title'] = 'Departments'; $view_data['brand'] = $this->brand;
        return view('business.dashboard.departments')->with($view_data);
    }

    public function admins()
    {
        $view_data['title'] = 'Admins'; $view_data['brand'] = $this->brand;
        return view('business.dashboard.admins')->with($view_data);
    }

    public function activities()
    {
        $view_data['title'] = 'Activities'; $view_data['brand'] = $this->brand;
        return view('business.dashboard.activities')->with($view_data);
    }

    public function cashOutFlow()
    {
        $view_data['title'] = 'Cash Out Flow'; $view_data['brand'] = $this->brand;
        return view('business.dashboard.cashOutFlow')->with($view_data);
    }

    public function messages()
    {
        $view_data['title'] = 'Messages'; $view_data['brand'] = $this->brand;
        return view('business.dashboard.messages')->with($view_data);
    }
}
