<?php

namespace App\Http\Controllers\sub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;
use App\Models\Business;
use App\Models\BusinessAdmin;

class EmployeeController extends Controller
{
    public function createEmployee(Request $request)
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
                    'role' => 'employee',
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
                
                Mail::send('mail.businessEmployeeCredentials', $data, function($message)use($data) {
                    $message->to($data["email"])
                    ->subject($data["title"]);
                });
                
                DB::commit();
            }
            
        } catch (\Exception $e) {
            
            DB::rollBack();
            return response()->json([
                'status'=>400,
                'message'=>'Could not create employee account. Try again'
            ]);
        }
        
        return response()->json([
            'status'=>200
        ]);
    }
}
