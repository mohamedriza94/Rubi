<?php

namespace App\Http\Controllers\Sub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function read()
    {
        $tasks = Task::where('department',auth()->guard('businessAdmin')->user()->department)->orderBy('id','DESC')->get();
        return response()->json(['data' => $tasks]);
    }
    
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [     
                'title' => 'required|string',
                'description' => 'required|string',
            ], [
                'title.required' => 'Title is required',
                'description.required' => 'Description is required',
                
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
                
                //generate a task no
                $taskNo = rand(0000,9999); $exists = Task::where('no', $taskNo)->exists();
                while ($exists) {
                    $taskNo = rand(0000,9999); $exists = Task::where('no', $taskNo)->exists();
                }
                
                //Record Activity
                $data = [ 'userType' => 'admin', 'activity' => 'Created Task No.'.$taskNo, 
                'user' => auth()->guard('businessAdmin')->user()->id ];
                $activityController = new \App\Http\Controllers\common\ActivityController;
                $activityController->recordActivity($data);
                
                Task::create([ 'title' => $request->input('title'), 
                'description' => $request->input('description'),
                'status' => 'pending',
                'no' => $taskNo,
                'business' => $businessNo,
                'department' => $departmentNo,
                'admin' => auth()->guard('businessAdmin')->user()->id,
                'start' => '-',
                'end' => '-']);
                
                DB::commit();
            }
            
        } catch (\Exception $e) {
            
            DB::rollBack();
            return response()->json([
                'status'=>400,
                'message'=>'Could not create task. Try again'
            ]);
        }
        
        return response()->json([
            'status'=>200
        ]);
    }
    
    public function readOne($id)
    {
        $task = Task::find($id);
        return response()->json(['data' => $task]);
    }
    
    public function updateStatus(Request $request)
    {
        DB::beginTransaction();
        try 
        {
            $id = $request->input('id');
            
            //get current status
            $task = Task::where('id', $id)->first(); 
            $currentStatus = $business->status;
            $message = '';
            
            switch ($currentStatus) 
            {
                case 'pending':
                    Task::where('id', $id)->update(['status' => 'started']); 
                    $message = 'Task Started';
                break;
                case 'started':
                    Task::where('id', $id)->update(['status' => 'completed']); 
                    $message = 'Task Completed';
                break;
            }
            
            DB::commit();
        } 
        catch (\Exception $e) 
        {
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Failure. Try again']);
        }
        return response()->json(['status' => 200, 'message' => $message]);
    }
    
    public function readTop()
    {
        $task = Task::where('status','pending')->first();
        return response()->json(['data' => $task]);
    }
}