<?php

namespace App\Http\Controllers\Sub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Payroll;
use App\Models\BusinessAdmin;

class PayrollController extends Controller
{
    public function read()
    {
        $userBusiness = auth()->guard('businessAdmin')->user();
        
        $payroll = Payroll::join('business_Admins','payrolls.employee','=','business_Admins.id')->
        where('payrolls.business',$userBusiness->business)->get([
            'payrolls.status AS status',
            'business_admins.fullname AS fullname',
            'payrolls.due AS due',
            'payrolls.paid AS paid',
            'payrolls.updated_at AS updated_at',
            'payrolls.id AS id',
            'business_admins.id AS id',
        ]);
        
        return response()->json([
            'data'=>$payroll 
        ]);
    }

    public function setPayroll()
    {
        $userBusiness = auth()->guard('businessAdmin')->user();
        
        // Get employees' IDs to array
        $employeeIds = BusinessAdmin::where('status','active')
        ->where('role','employee')
        ->where('business',$userBusiness->business)
        ->pluck('id')
        ->toArray();
        
        // Create payroll records
        foreach ($employeeIds as $employeeId) {
            Payroll::create([
                'employee' => $employeeId,
                'business' => $userBusiness->business,
                'status' => 'pending',
                'due' => $userBusiness->salary,
                'paid' => '0'
            ]);
        }
    }
    
}
