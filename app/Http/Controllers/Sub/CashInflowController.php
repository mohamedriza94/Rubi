<?php

namespace App\Http\Controllers\Sub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashInflow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CashInflowController extends Controller
{
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [     
                'amount' => 'required|numeric'
            ], [
                'amount.required' => 'Amount is required'
            ]);
            
            if ($validator->fails()) { 
                return response()->json([
                    'status'=>800,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {   
                $userData = auth()->guard('businessAdmin')->user();
                CashInflow::create([ 'note' => $request->input('note'),'amount' => $request->input('amount'), 'business' => $userData->business]);
                
                DB::commit();
            }
            
        } catch (\Exception $e) {
            
            DB::rollBack();
            return response()->json([
                'status'=>400,
                'message'=>'Could not record amount. Try again'
            ]);
        }
        
        return response()->json([
            'status'=>200,
            'message'=>'Amount Recorded'
        ]);
    }
}
