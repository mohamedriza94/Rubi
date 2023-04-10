<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;
use App\Models\Business;
use App\Models\BusinessAdmin;

class BusinessAdminController extends Controller
{
    public function read()
    {
        $admins = BusinessAdmin::join('departments','business_admins.department','=','departments.id')->
        where('business_admins.business',auth()->guard('business')->user()->id)
        ->where('business_admins.role','admin')->orderBy('business_admins.id','DESC')->get([
            'business_admins.fullname AS fullname',
            'business_admins.status AS status',
            'business_admins.photo AS photo',
            'business_admins.id AS id',
            'departments.name AS department',
        ]);
        return response()->json(['data' => $admins]);
    }

    public function readOne($id)
    {
        $admin = BusinessAdmin::find($id);
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
                'email' => 'required|string|email|unique:business_admins',
                'photo' => 'required|image',
                'telephone' => 'required|string',
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
                //generate a business no
                $no = rand(0000,9999);
                $exists = BusinessAdmin::where('no', $no)->exists();
                while ($exists) {
                    $no = rand(0000,9999);
                    $exists = BusinessAdmin::where('no', $no)->exists();
                }

                //Record Activity
                $data = [ 'userType' => 'business', 'activity' => 'Added a new admin', 
                'user' => auth()->guard('business')->user()->id ];
                $activityController = new \App\Http\Controllers\common\ActivityController;
                $activityController->recordActivity($data);
                
                $password = rand(00000000,99999999);
                $hashedPassword = Hash::make($password);

                //generate photo path
                $photoPath = request('photo')->store('businessAdmin','public');
                $photo = '/'.'storage/'.$photoPath;

                BusinessAdmin::create([ 
                    'no' => $no,
                    'fullname' => $request->input('fullname'),
                    'dob' => $request->input('dob'),
                    'role' => 'admin',
                    'status' => 'active',
                    'email' => $request->input('email'),
                    'photo' => $photo,
                    'telephone' => $request->input('telephone'),
                    'business' => auth()->guard('business')->user()->id,
                    'department' => $request->input('department'),
                    'password' => $hashedPassword]);

                //Send Credentials in Email
                $data["email"] = $request->input('email');
                $data["title"] = "Admin Credentials";
                $data["password"] = $password;
                $data["business"] = auth()->guard('business')->user()->name;
                
                Mail::send('mail.businessAdminCredentials', $data, function($message)use($data) {
                    $message->to($data["email"])
                    ->subject($data["title"]);
                });
                
                DB::commit();
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
            $currentStatus = $businessAdmin->status;
            
            switch ($currentStatus) {
                case 'active':
                    BusinessAdmin::where('id', $id)->update(['status' => 'inactive']); 
                    break;
                    case 'inactive':
                        BusinessAdmin::where('id', $id)->update(['status' => 'active']); 
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
                'fullname' => 'required|string',
                'dob' => 'required|string',
                'telephone' => 'required|string',
            ], [
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
                BusinessAdmin::where('id',$request->input('id'))->update([ 
                    'fullname' => $request->input('fullname'),
                    'dob' => $request->input('dob'),
                    'department' => $request->input('department'),
                    'telephone' => $request->input('telephone')]);
                    
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
    
    public function updateProfilePicture(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [     
                'photo' => 'required|image'
            ], [
                'photo.required' => 'Photo is required',
                'photo.image' => 'Photo must be an image',
            ]);
            
            if ($validator->fails()) { 
                return response()->json([
                    'status'=>800,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
                //generate photo path
                $photoPath = request('photo')->store('businessAdmin','public');
                $photo = '/'.'storage/'.$photoPath;
                
                BusinessAdmin::where('id', $request->input('id'))->update([ 
                    'photo' => $photo]);
                    
                    DB::commit();
                }
                
            } catch (\Exception $e) {
                
                DB::rollBack();
                return response()->json([
                    'status'=>400,
                    'message'=>'Could not update the profile picture. Try again'
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
