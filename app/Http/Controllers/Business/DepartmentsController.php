<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;

class DepartmentsController extends Controller
{
    public function read()
    {
        $departments = Department::where('business',auth()->guard('business')->user()->id)->orderBy('id','DESC')->get();
        return response()->json(['data' => $departments]);
    }
    
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [     
                'department' => 'required|string',
                'status' => 'required|string',
            ], [
                'department.required' => 'Choose a department',
                'status.required' => 'Choose a status',
                
            ]);
            
            if ($validator->fails()) { 
                return response()->json([
                    'status'=>800,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
                $businessNo = auth()->guard('business')->user()->id;
                //check if department already exists
                $exists = Department::where('name',$request->input('department'))->where('business',$businessNo)->exists();
                
                if($exists)
                {
                    return response()->json([
                        'status'=>600,
                        'message'=>'This department already exists'
                    ]);
                }
                else
                {
                    //Record Activity
                    $data = [ 'userType' => 'business', 'activity' => 'Added '.$request->input('department').' department', 
                    'user' => auth()->guard('business')->user()->id ];
                    $activityController = new \App\Http\Controllers\common\ActivityController;
                    $activityController->recordActivity($data);

                    $nickname = $request->input('nickname');
                    if($request->input('nickname') == "")
                    {
                        $nickname = "-";
                    }
                    
                    Department::create([ 'name' => $request->input('department'), 
                    'status' => $request->input('status'),
                    'nickname' => $nickname,
                    'business' => $businessNo]);
                    
                    DB::commit();
                }
                
                
            }
            
        } catch (\Exception $e) {
            
            DB::rollBack();
            return response()->json([
                'status'=>400,
                'message'=>'Could not create department. Try again'
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
            $business = Department::where('id', $id)->first(); 
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
        }
