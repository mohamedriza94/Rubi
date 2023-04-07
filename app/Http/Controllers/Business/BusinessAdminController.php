<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;
use App\Models\Business;
use App\Models\BusinessAdmin;

class BusinessAdminController extends Controller
{
    public function read()
    {
        $admins = BusinessAdmin::where('business',auth()->guard('business')->user()->id)->orderBy('id','DESC')->get();
        return response()->json(['data' => $admins]);
    }

    public function readOne($id)
    {
        $admin = BusinessAdmin::where('id',$id)->get();
        return response()->json(['data' => $admin]);
    }
    
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [     
                'department' => 'required|string',
                'fullname' => 'required|string',
                'dob' => 'required|string',
                'email' => 'required|string|email',
                'photo' => 'required|string',
                'telephone' => 'required|string',
                'password' => 'required|confirmed|min:8',
            ], [
                'department.required' => 'Choose a department',
                'fullname.required' => 'Full name is required',
                'dob.required' => 'Date of birth is required',
                'email.required' => 'Email is required',
                'photo.required' => 'Photo is required',
                'telephone.required' => 'Telephone number is required',
            ]);
            
            if ($validator->fails()) { 
                return response()->json([
                    'status'=>800,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
                $businessAdminNo = rand(1515,9999);
                //check if admin with same number already exists
                $exists = BusinessAdmin::where('no',$businessAdminNo)->exists();
                
                if($exists)
                {
                    $businessAdminNo = rand(1515,9999);
                }
                else
                {
                    //Record Activity
                    $data = [ 'userType' => 'business', 'activity' => 'Added a new admin', 
                    'user' => auth()->guard('business')->user()->id ];
                    $activityController = new \App\Http\Controllers\common\ActivityController;
                    $activityController->recordActivity($data);
                    
                    $hashedPassword = Hash::make($request->input('password'));

                    BusinessAdmin::create([ 
                        'no' => $businessAdminNo,
                        'fullname' => $request->input('fullname'),
                        'dob' => $request->input('dob'),
                        'status' => 'active',
                        'email' => $request->input('email'),
                        'photo' => $request->input('photo'),
                        'telephone' => $request->input('telephone'),
                        'business' => auth()->guard('business')->user()->id,
                        'department' => $request->input('department'),
                        'password' => $hashedPassword]);
                    
                    DB::commit();
                }
                
                
            }
            
        } catch (\Exception $e) {
            
            DB::rollBack();
            return response()->json([
                'status'=>400,
                'message'=>'Could not create admin account. Try again'
            ]);
        }
        
        return response()->json([
            'status'=>200
        ]);
    }
    
    public function updateStatus(Request $request)
    {
        DB::beginTransaction();
        try 
        {
            $id = $request->input('id');
            
            //get current status
            $businessAdmin = BusinessAdmin::where('id', $id)->first(); 
            $currentStatus = $business->status;
            
            switch ($currentStatus) {
                case 'active':
                    Department::where('id', $id)->update(['status' => 'inactive']); 
                    break;
                    case 'inactive':
                        Department::where('id', $id)->update(['status' => 'active']); 
                        break;
                    }
                    
                    DB::commit();
                } 
                catch (\Exception $e) 
                {
                    DB::rollBack();
                    return response()->json(['status' => 400, 'message' => 'Failure. Try again']);
                }
                return response()->json(['status' => 200, 'message' => 'Status Changed']);
    }
    
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [     
                'department' => 'required|string',
                'fullname' => 'required|string',
                'dob' => 'required|string',
                'telephone' => 'required|string',
            ], [
                'department.required' => 'Choose a department',
                'fullname.required' => 'Full name is required',
                'dob.required' => 'Date of birth is required',
                'telephone.required' => 'Telephone number is required',
            ]);
            
            if ($validator->fails()) { 
                return response()->json([
                    'status'=>800,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
                BusinessAdmin::where('id', $request->input('fullname'))->update([ 
                    'fullname' => $request->input('fullname'),
                    'dob' => $request->input('dob'),
                    'telephone' => $request->input('telephone'),
                    'department' => $request->input('department'),]);
                    
                    DB::commit();
                }
                
            } catch (\Exception $e) {
                
                DB::rollBack();
                return response()->json([
                    'status'=>400,
                    'message'=>'Could not update this admin\'s account. Try again'
                ]);
            }
            
            return response()->json([
                'status'=>200
            ]);
    }
    
    public function delete($id)
    {
        DB::beginTransaction();
        try {
                BusinessAdmin::whereIn('id', $id)->delete();
                DB::commit();
                
            } catch (\Exception $e) {
                
                DB::rollBack();
                return response()->json([
                    'status'=>400,
                    'message'=>'Could not delete this admin\'s account. Try again'
                ]);
            }
            
        return response()->json(['status' => 200, 'message' => 'Deleted']);
    }
}
