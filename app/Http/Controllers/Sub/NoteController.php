<?php

namespace App\Http\Controllers\sub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function read()
    {
        $employee = auth()->guard('businessAdmin')->user()->id;

        $notes = Note::join('business_admins','notes.employee','=','business_admins.id')->
        where('notes.employee',$employee)->get([
            'notes.subject AS subject',
            'notes.isViewed AS isViewed',
            'notes.created_at AS created_at',
            'notes.no AS no']);

        return response()->json([
            'data' => $notes
        ]);
    }
    
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [     
                'subject' => 'required|string',
                'note' => 'required|string',
            ], [
                'subject.required' => 'Subject is required',
                'note.required' => 'Note is required',
                
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
                $noteNo = rand(0000,9999); $exists = Note::where('no', $noteNo)->exists();
                while ($exists) {
                    $noteNo = rand(0000,9999); $exists = Note::where('no', $noteNo)->exists();
                }
                
                //Record Activity
                $data = [ 'userType' => 'employee', 'activity' => 'Created Note No.'.$noteNo, 
                'user' => auth()->guard('businessAdmin')->user()->id ];
                $activityController = new \App\Http\Controllers\common\ActivityController;
                $activityController->recordActivity($data);
                
                Note::create([ 'subject' => $request->input('subject'), 
                'note' => $request->input('note'),
                'no' => $noteNo,
                'business' => $businessNo,
                'department' => $departmentNo,
                'employee' => auth()->guard('businessAdmin')->user()->id,
                'isViewed' => '0']);
                
                DB::commit();
            }
            
        } catch (\Exception $e) {
            
            DB::rollBack();
            return response()->json([
                'status'=>400,
                'message'=>'Could not make note. Try again'
            ]);
        }
        
        return response()->json([
            'status'=>200,
            'message'=>'Noted!'
        ]);
    }
}
