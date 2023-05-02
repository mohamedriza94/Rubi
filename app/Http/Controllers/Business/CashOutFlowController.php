<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PettyExpense;
use App\Models\Payroll;

class CashOutFlowController extends Controller
{
    public function read($type)
    {
        $business = auth()->guard('business')->user();
        $data = '';

        switch ($type) {
            case 'payroll':
                $data = Payroll::where('business',$business->id)->get();
            break;
            
            case 'pettyExpense':
                $data = PettyExpense::where('business',$business->id)->get();
            break;
        }

        return response()->json([
            'data' => $data
        ]);
    }
}
