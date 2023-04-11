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

    public function tasks()
    {
        $view_data['title'] = 'Tasks'; $view_data['brand'] = $this->brand;
        return view('sub.dashboard.tasks')->with($view_data);
    }

    public function activities()
    {
        $view_data['title'] = 'Activities'; $view_data['brand'] = $this->brand;
        return view('sub.dashboard.activities')->with($view_data);
    }

    public function notes()
    {
        $view_data['title'] = 'Notes'; $view_data['brand'] = $this->brand;
        return view('sub.dashboard.notes')->with($view_data);
    }

    public function pettyExpense()
    {
        $view_data['title'] = 'Petty Expense'; $view_data['brand'] = $this->brand;
        return view('sub.dashboard.pettyExpense')->with($view_data);
    }

    public function attendance()
    {
        $view_data['title'] = 'Attendance'; $view_data['brand'] = $this->brand;
        return view('sub.dashboard.attendance')->with($view_data);
    }

    public function payroll()
    {
        $view_data['title'] = 'Payroll'; $view_data['brand'] = $this->brand;
        return view('sub.dashboard.payroll')->with($view_data);
    }

    public function employees()
    {
        $view_data['title'] = 'Employees'; $view_data['brand'] = $this->brand;
        return view('sub.dashboard.employees')->with($view_data);
    }

    public function pettyExpenseReport()
    {
        $view_data['title'] = 'Petty Expense Report'; $view_data['brand'] = $this->brand;
        return view('sub.dashboard.pettyExpenseReport')->with($view_data);
    }
}
