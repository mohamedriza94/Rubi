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
use App\Models\Vacancy;
use App\Models\Application;
use App\Models\BusinessAdmin;

class EmployeeController extends Controller
{
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'department' => 'required|string',
                'fullname' => 'required|string',
                'dob' => 'required|string',
                'salary' => 'required|numeric',
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
            } else {
                //generate a business no
                $no = rand(0000, 9999);
                $exists = BusinessAdmin::where('no', $no)->exists();
                while ($exists) {
                    $no = rand(0000, 9999);
                    $exists = BusinessAdmin::where('no', $no)->exists();
                }

                //Record Activity
                $data = [ 'userType' => 'business', 'activity' => 'Added a new Employee',
                'user' => auth()->guard('businessAdmin')->user()->business ];
                $activityController = new \App\Http\Controllers\common\ActivityController();
                $activityController->recordActivity($data);

                $password = rand(00000000, 99999999);
                $hashedPassword = Hash::make($password);

                //generate photo path
                $photoPath = request('photo')->store('businessAdmin', 'public');
                $photo = '/'.'storage/'.$photoPath;

                //get position
                $position = Application::where('email',$request->input('email'))->first();
                $position = $position->vacancy;
                $position = Vacancy::find($position);
                $position = $position->position;

                BusinessAdmin::create([
                    'no' => $no,
                    'fullname' => $request->input('fullname'),
                    'dob' => $request->input('dob'),
                    'role' => 'employee',
                    'status' => 'active',
                    'paymentStatus' => 'no',
                    'email' => $request->input('email'),
                    'salary' => $request->input('salary'),
                    'position' => $position,
                    'photo' => $photo,
                    'telephone' => $request->input('telephone'),
                    'business' => auth()->guard('businessAdmin')->user()->business,
                    'department' => $request->input('department'),
                    'password' => $hashedPassword]);

                Application::where('email', $request->input('email'))->update(['status' => 'recruited']);

                //get business
                $business = auth()->guard('businessAdmin')->user()->business;
                $business = Business::find($business);
                $business = $business->name;

                //Send Credentials in Email
                $data["email"] = $request->input('email');
                $data["title"] = "Employee Credentials";
                $data["password"] = $password;
                $data["business"] = $business;

                Mail::send('mail.businessEmployeeCredentials', $data, function ($message) use ($data) {
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

    public function updateStatus(Request $request)
    {
        DB::beginTransaction();
        try {
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
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Failure. Try again']);
        }
        return response()->json(['status' => 200, 'message' => 'Status Changed']);
    }

    public function read()
    {
        $businessAdmins = BusinessAdmin::join('departments','business_admins.department','=','departments.id')
        ->where('business_admins.business', auth()->guard('businessAdmin')->user()->business)
        ->where('business_admins.role','employee')
        ->orderBy('business_admins.id', 'DESC')->get([
            'departments.name AS department',
            'business_admins.fullname AS fullname',
            'business_admins.status AS status',
            'business_admins.created_at AS created_at',
            'business_admins.photo AS photo',
            'business_admins.id AS id',
        ]);
        return response()->json(['data' => $businessAdmins]);
    }

    public function readOne($id)
    {
        $businessAdmin = BusinessAdmin::join('departments','business_admins.department','=','departments.id')
        ->where('business_admins.id', $id)->first([
            'departments.name AS department',
            'business_admins.fullname AS fullname',
            'business_admins.dob AS dob',
            'business_admins.email AS email',
            'business_admins.photo AS photo',
            'business_admins.salary AS salary',
            'business_admins.position AS position',
            'business_admins.telephone AS telephone',
            'business_admins.id AS id',
        ]);
        return response()->json(['data' => $businessAdmin]);
    }
    
    public function readActiveDepartments()
    {
        $departments = Department::where('business',auth()->guard('businessAdmin')->user()->business)->where('status','active')->orderBy('id','DESC')->get();
        return response()->json(['data' => $departments]);
    }
}
