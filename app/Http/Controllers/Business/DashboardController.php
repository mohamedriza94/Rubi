<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\PettyExpense;
use App\Models\Payroll;
use App\Models\Task;
use Carbon\Carbon;
use App\Models\BusinessAdmin;

class DashboardController extends Controller
{
    public function statistics()
    {
        $userData = auth()->guard('business')->user();
        
        $departments = Department::where('business',$userData->id)->orderBy('id','DESC')->get();
        $departmentCount = Department::where('business',$userData->id)->count();
        $businessAdminCount = BusinessAdmin::where('business',$userData->id)->where('role','admin')->count();
        $businessEmployeeCount = BusinessAdmin::where('business',$userData->id)->where('role','employee')->count();
        $pendingTasksCount = Task::where('business',$userData->id)->where('status','pending')->count();
        
        //get today's cash out
        $totalPaidAmount = Payroll::where('business', $userData->id)->whereDate('updated_at',today())->sum('paid');
        $totalPettyExpenseAmount = PettyExpense::where('business', $userData->id)->whereDate('updated_at',today())->sum('amount');
        $totalCashOutToday = $totalPaidAmount + $totalPettyExpenseAmount;
        
        //get this months cash out
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        $totalPaidAmountThisMonth = Payroll::where('business', $userData->id)
        ->whereBetween('updated_at', [$startDate, $endDate])
        ->sum('paid');
        
        $totalPettyExpenseAmountThisMonth = PettyExpense::where('business', $userData->id)
        ->whereBetween('updated_at', [$startDate, $endDate])
        ->sum('amount');
        $totalCashOutThisMonth = $totalPaidAmountThisMonth + $totalPettyExpenseAmountThisMonth;

        $recruitmentRate = BusinessAdmin::where('status', 'active')
        ->where('role', 'admin')
        ->where('business', $userData->id)
        ->select(DB::raw("DATE_FORMAT(created_at,'%M %Y') as monthYear"), DB::raw("COUNT(*) as count"))
        ->groupBy('monthYear')
        ->get();
    
        
        return response()->json([
            'departments' => $departments, 
            'departmentCount' => $departmentCount,
            'businessAdminCount' => $businessAdminCount,
            'businessEmployeeCount' => $businessEmployeeCount,
            'pendingTasksCount' => $pendingTasksCount,
            'totalCashOutToday' => 'LKR '.$totalCashOutToday,
            'totalCashOutThisMonth' => 'LKR '.$totalCashOutThisMonth,
            'recruitmentRate' => $recruitmentRate
        ]);
    }
}
