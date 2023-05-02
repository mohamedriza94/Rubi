<?php

namespace App\Http\Controllers\sub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PettyExpense;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class pettyExpenseController extends Controller
{
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [     
                'purpose' => 'required|string',
                'amount' => 'required|numeric|min:1',
            ], [
                'purpose.required' => 'Purpose is required',
                'amount.required' => 'Amount is required',
                'amount.numeric' => 'Amount should be a number'
            ]);
            
            if ($validator->fails()) { 
                return response()->json([
                    'status'=>800,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
                $businessNo = auth()->guard('businessAdmin')->user()->business;
                $departmentNo = auth()->guard('businessAdmin')->user()->department;
                
                //generate a number
                $no = rand(0000,9999); 
                $exists = PettyExpense::where('no', $no)->exists();
                while ($exists) {
                    $no = rand(0000,9999); $exists = PettyExpense::where('no', $no)->exists();
                }
                
                //Record Activity
                $data = [ 'userType' => 'employee', 'activity' => 'Recorded petty expense No.'.$no.' of Rs.'.$request->input('amount'), 
                'user' => auth()->guard('businessAdmin')->user()->id ];
                $activityController = new \App\Http\Controllers\common\ActivityController;
                $activityController->recordActivity($data);
                
                PettyExpense::create([ 'purpose' => $request->input('purpose'), 
                'amount' => $request->input('amount'),
                'no' => $no,
                'business' => $businessNo,
                'department' => $departmentNo,
                'employee' => auth()->guard('businessAdmin')->user()->id]);
                
                DB::commit();
            }
            
        } catch (\Exception $e) {
            
            DB::rollBack();
            return response()->json([
                'status'=>400,
                'message'=>'Could not record expense. Try again'
            ]);
        }
        
        return response()->json([
            'status'=>200,
            'message'=>'Expense recorded!'
        ]);
    }

    public function read()
    {
        $employee = auth()->guard('businessAdmin')->user()->id;
        $pettyExpenses = PettyExpense::where('employee',$employee)->get();

        return response()->json([
            'data' => $pettyExpenses
        ]);
    }
}
