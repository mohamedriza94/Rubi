<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Task;
use App\Models\BusinessAdmin;

class DashboardController extends Controller
{
    public function statistics()
    {
        $id = auth()->guard('business')->user()->id;

        $departments = Department::where('business',$id)->orderBy('id','DESC')->get();
        $departmentCount = Department::where('business',$id)->count();
        $businessAdminCount = BusinessAdmin::where('business',$id)->where('role','admin')->count();
        $businessEmployeeCount = BusinessAdmin::where('business',$id)->where('role','employee')->count();
        $pendingTasksCount = Task::where('business',$id)->where('status','pending')->count();

        return response()->json([
            'departments' => $departments, 
            'departmentCount' => $departmentCount,
            'businessAdminCount' => $businessAdminCount,
            'businessEmployeeCount' => $businessEmployeeCount,
            'pendingTasksCount' => $pendingTasksCount
        ]);
    }
}
