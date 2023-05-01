<?php

namespace App\Http\Controllers\Sub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Payroll;
use App\Models\BusinessAdmin;
use App\Models\PaymentDetails;

class PayrollController extends Controller
{
    public function read($type)
    {
        $userBusiness = auth()->guard('businessAdmin')->user();
        $payroll = '';
        switch ($type) {
            case 'all':
                $payroll = Payroll::join('business_admins','payrolls.employee','=','business_admins.id')->
                where('payrolls.business',$userBusiness->business)->get([
                    'payrolls.status AS status',
                    'business_admins.fullname AS fullname',
                    'payrolls.due AS due',
                    'payrolls.paid AS paid',
                    'payrolls.updated_at AS updated_at',
                    'payrolls.id AS id',
                ]);        
            break;
            case 'pending':
                $payroll = Payroll::join('business_admins','payrolls.employee','=','business_admins.id')->
                where('payrolls.status','pending')->
                where('payrolls.business',$userBusiness->business)->get([
                    'payrolls.status AS status',
                    'business_admins.fullname AS fullname',
                    'payrolls.due AS due',
                    'payrolls.paid AS paid',
                    'payrolls.updated_at AS updated_at',
                    'payrolls.id AS id',
                ]);        
            break;
            case 'paid':
                $payroll = Payroll::join('business_admins','payrolls.employee','=','business_admins.id')->
                where('payrolls.status','paid')->
                where('payrolls.business',$userBusiness->business)->get([
                    'payrolls.status AS status',
                    'business_admins.fullname AS fullname',
                    'payrolls.due AS due',
                    'payrolls.paid AS paid',
                    'payrolls.updated_at AS updated_at',
                    'payrolls.id AS id',
                ]);     
            break;
        }
        
        
        
        return response()->json([
            'data'=>$payroll 
        ]);
    }
    public function search($search)
    {
        $userBusiness = auth()->guard('businessAdmin')->user();

        $payroll = Payroll::join('business_admins','payrolls.employee','=','business_admins.id')->
        where('business_admins.fullname','Like','%'.$search.'%')->
        where('payrolls.business',$userBusiness->business)->get([
            'payrolls.status AS status',
            'business_admins.fullname AS fullname',
            'payrolls.due AS due',
            'payrolls.paid AS paid',
            'payrolls.updated_at AS updated_at',
            'payrolls.id AS id',
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

    public function pay(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric'
            ], [
                'amount.required' => 'Enter the payment amount',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'=>800,
                    'errors'=>$validator->messages()
                ]);
            } else {
                
                $payroll_id = $request->input('id');

                //get employee details
                $payroll = Payroll::find($payroll_id);
                $employee = BusinessAdmin::find($payroll->employee);
                $employee_payment_details = PaymentDetails::where('employee',$employee->id)->first();

                //update payroll
                $paid = $request->input('amount'); 
                $due = $payroll->due;
                if($paid > $due)
                {
                    $paid = $due;
                }
                $finalDue = $due - $paid; //calculate remaining payment

                Payroll::where('id',$payroll_id)->update(['status'=>'paid','paid' => $paid,'due' => $finalDue]);
                
                //Send Payment Receipt in Mail
                $data["email"] = $employee->email;
                $data["title"] = "Salary Payment Receipt";
                $data["paid"] = $paid;
                $data["due"] = $finalDue;
                $data["bank"] = $employee_payment_details->bank;
                $data["accountNo"] = $employee_payment_details->accountNo;
                $data["date"] = NOW();
                
                Mail::send('mail.salaryPaymentReceipt', $data, function ($message) use ($data) {
                    $message->to($data["email"])
                    ->subject($data["title"]);
                });
                
                DB::commit();
            }

        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                'status'=>400,
                'message'=>'Could not make payment. Try again'
            ]);
        }

        return response()->json([
            'status'=>200
        ]);
    }
}
