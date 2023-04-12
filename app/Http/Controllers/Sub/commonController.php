<?php

namespace App\Http\Controllers\sub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Note;
use App\Models\BusinessAdmin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class commonController extends Controller
{
    public function changePassword(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [     
                'password' => 'required|min:8'
            ], [
                'password.required' => 'Password is required'
            ]);
            
            if ($validator->fails()) { 
                return response()->json([
                    'status'=>800,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {   
                $hashedPassword = Hash::make($request->input('password'));
                BusinessAdmin::where('id',auth()->guard('businessAdmin')->user()->id)->update([ 'password' => $hashedPassword]);
                
                DB::commit();
            }
            
        } catch (\Exception $e) {
            
            DB::rollBack();
            return response()->json([
                'status'=>400,
                'message'=>'Could not change password. Try again'
            ]);
        }
        
        return response()->json([
            'status'=>200,
            'message'=>'Password changed succesfully'
        ]);
    }

    public function statistics()
    {
        $department = auth()->guard('businessAdmin')->user()->department;

        $ongoingTaskCount = Task::where('department',$department)->where('status','started')->count();
        $pendingTaskCount = Task::where('department',$department)->where('status','pending')->count();
        $completedTaskCount = Task::where('department',$department)->where('status','completed')->count();
        $unopenedNotesCount = Note::where('department',$department)->where('isViewed','0')->count();

        $tasksStartedToday = Task::where('status','started')->whereDate('updated_at', today())->get();
        $notes = Note::join('business_admins','notes.employee','=','business_admins.id')->
        where('notes.department',$department)->get([
            'notes.subject AS subject',
            'business_admins.photo AS employeePhoto',
            'business_admins.fullname AS employeeName',
            'notes.isViewed AS isViewed',
            'notes.created_at AS created_at',
            'notes.id AS id']);

        return response()->json([
            'ongoingTaskCount' => $ongoingTaskCount, 
            'pendingTaskCount' => $pendingTaskCount,
            'completedTaskCount' => $completedTaskCount,
            'unopenedNotesCount' => $unopenedNotesCount,
            'tasksStartedToday' => $tasksStartedToday,
            'notes' => $notes
        ]);
    }
}
