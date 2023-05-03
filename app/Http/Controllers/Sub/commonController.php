<?php

namespace App\Http\Controllers\sub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Note;
use App\Models\Vacancy;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\PettyExpense;
use Carbon\Carbon;
use App\Models\BusinessAdmin;
use App\Models\Application;
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
        $userData = auth()->guard('businessAdmin')->user();

        $ongoingTaskCount = Task::where('department',$userData->department)->where('status','started')->count();
        $pendingTaskCount = Task::where('department',$userData->department)->where('status','pending')->count();
        $completedTaskCount = Task::where('department',$userData->department)->where('status','completed')->count();
        $unopenedNotesCount = Note::where('department',$userData->department)->where('isViewed','0')->count();

        $todaysAttendanceCount = Attendance::where('business',$userData->business)->whereDate('created_at', today())->count();
        $activeEmployeesCount = BusinessAdmin::where('role','employee')->where('status','active')->where('business',$userData->business)->count();
        $totalEmployeesCount = BusinessAdmin::where('business',$userData->business)->count();
        
        $activeVacanciesCount = Vacancy::where('business',$userData->business)->where('status','active')->count();

        //get applications of this business
        $application = Application::join('vacancies','applications.vacancy','=','vacancies.id')
        ->where('vacancies.business',$userData->business);

        $pendingApplicationsCount = $application->where('applications.status','pending')->count();
        $shortlistedApplicationsCount = $application->where('applications.status','shortlisted')->count();
        
        $pendingSalaryPaymentsCount = Payroll::where('business',$userData->business)->where('status','pending')->count();
        $completedSalaryPaymentsCount = Payroll::where('business',$userData->business)->where('status','paid')->count();
        $totalDuePaymentAmount = Payroll::where('business', $userData->business)->sum('due');
        $todaysPettyExpenseAmount = PettyExpense::where('business', $userData->business)->whereDate('created_at', today())->sum('amount');

        $tasksStartedToday = Task::where('status','started')->whereDate('updated_at', today())->get();
        $notes = Note::join('business_admins','notes.employee','=','business_admins.id')->
        where('notes.department',$userData->department)->get([
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
                'todaysAttendanceCount' => $todaysAttendanceCount,
                'activeEmployeesCount' => $activeEmployeesCount,
                'totalEmployeesCount' => $totalEmployeesCount,
                'activeVacanciesCount' => $activeVacanciesCount,
                'pendingApplicationsCount' => $pendingApplicationsCount,
                'shortlistedApplicationsCount' => $shortlistedApplicationsCount,
                'pendingSalaryPaymentsCount' => $pendingSalaryPaymentsCount,
                'completedSalaryPaymentsCount' => $completedSalaryPaymentsCount,
                'totalDueSalaryAmountCount' => 'LKR '.$totalDuePaymentAmount,
                'todaysPettyExpenseAmountCount' => 'LKR '.$todaysPettyExpenseAmount,
                
                'notes' => $notes
            ]);
    }
    
    public function getChart()
    {
        $userData = auth()->guard('businessAdmin')->user();
        $response = [];
        
        $recruitmentRate = BusinessAdmin::where('status', 'active')
        ->where('role', 'employee')
        ->where('business', $userData->business)
        ->select(DB::raw("DATE_FORMAT(created_at,'%M %Y') as monthYear"), DB::raw("COUNT(*) as count"))
        ->groupBy('monthYear')
        ->get();
        
        $pettyExpenseSum = PettyExpense::where('business', $userData->business)
        ->select(DB::raw("DATE_FORMAT(created_at,'%M %Y') as monthYear"), DB::raw("SUM(amount) as total"))
        ->groupBy('monthYear')
        ->get();
        
        $applicationsRate = Application::join('vacancies','applications.vacancy','=','vacancies.id')
        ->where('vacancies.business', $userData->business)
        ->select(DB::raw("DATE_FORMAT(applications.created_at,'%M %Y') as monthYear"), DB::raw("COUNT(*) as count"))
        ->groupBy('monthYear')
        ->get();
        
        $response['recruitmentRate'] = $recruitmentRate;
        $response['pettyExpenseSum'] = $pettyExpenseSum;
        $response['applicationsRate'] = $applicationsRate;
        
        return response()->json($response);
    }
}
