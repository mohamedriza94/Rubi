<?php

namespace App\Http\Controllers\sub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Vacancy;

class VacancyController extends Controller
{
    public function read()
    {
        $vacancies = Vacancy::where('business',auth()->guard('businessAdmin')->user()->business)->orderBy('id','DESC')->get();
        return response()->json(['data' => $vacancies]);
    }
    
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [     
                'position' => 'required|string',
                'description' => 'required|string',
                'type' => 'required|string',
                'status' => 'required|string',
                'salary' => 'required|numeric',
                'end' => 'required|string',
            ], [
                'position.required' => 'Position is required',
                'description.required' => 'Description is required',
                'type.required' => 'Type is required',
                'salary.required' => 'Salary is required',
                'end.required' => 'End Date is required',
                
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
                
                //Record Activity
                $data = [ 'userType' => 'admin', 'activity' => 'Created a Vacancy: '.$request->input('position'), 
                'user' => auth()->guard('businessAdmin')->user()->id ];
                $activityController = new \App\Http\Controllers\common\ActivityController;
                $activityController->recordActivity($data);
                
                Vacancy::create([ 'position' => $request->input('position'),
                'description' => $request->input('description'),
                'salaryRange' => $request->input('salaryRange'),
                'type' => $request->input('type'),
                'business' => $businessNo,
                'status' => $request->input('status'),
                'end' => $request->input('end')]);
                
                DB::commit();
            }
            
        } catch (\Exception $e) {
            
            DB::rollBack();
            return response()->json([
                'status'=>400,
                'message'=>'Could not post vacancy. Try again'
            ]);
        }
        
        return response()->json([
            'status'=>200,
            'message'=>'Vacancy posted'
        ]);
    }
    
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [     
                'id' => 'required',
                'position' => 'required|string',
                'description' => 'required|string',
                'type' => 'required|string',
                'end' => 'required|string',
            ], [
                'position.required' => 'Position is required',
                'description.required' => 'Description is required',
                'type.required' => 'Type is required',
                'end.required' => 'End Date is required',
                
            ]);
            
            if ($validator->fails()) { 
                return response()->json([
                    'status'=>800,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
                //Record Activity
                $data = [ 'userType' => 'admin', 'activity' => 'Created a Vacancy: '.$request->input('position'), 
                'user' => auth()->guard('businessAdmin')->user()->id ];
                $activityController = new \App\Http\Controllers\common\ActivityController;
                $activityController->recordActivity($data);
                
                Vacancy::where('id',$request->input('id'))->update([ 'position' => $request->input('position'),
                'description' => $request->input('description'),
                'salaryRange' => $request->input('salaryRange'),
                'type' => $request->input('type'),
                'end' => $request->input('end')]);
                
                DB::commit();
            }
            
        } catch (\Exception $e) {
            
            DB::rollBack();
            return response()->json([
                'status'=>400,
                'message'=>'Could not update vacancy. Try again'
            ]);
        }
        
        return response()->json([
            'status'=>200,
            'message'=>'Vacancy Updated'
        ]);
    }
    
    public function updateStatus(Request $request)
    {
        DB::beginTransaction();
        try 
        {
            $id = $request->input('id');
            
            //get current status
            $vacancy = Vacancy::where('id', $id)->first(); 
            $currentStatus = $vacancy->status;
            $message = '';
            
            switch ($currentStatus) 
            {
                case 'active':
                    Task::where('id', $id)->update(['status' => 'active']);
                break;
                case 'inactive':
                    Task::where('id', $id)->update(['status' => 'inactive']);
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
    
    public function readOne($id)
    {
        $vacancy = Vacancy::find($id);
        return response()->json(['data' => $vacancy]);
    }
}
