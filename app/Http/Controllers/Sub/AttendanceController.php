<?php

namespace App\Http\Controllers\sub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function recordAttendance($data)
    {
        $attendance = new Attendance;
        $attendance->business = $data['business'];
        $attendance->department = $data['department'];
        $attendance->employee = $data['employee'];
        $attendance->save();
    }

    public function read()
    {
        $business = auth()->guard('businessAdmin')->user()->business;

        $attendance = Attendance::join('business_admins.id','=','attendances.employee')
        ->join('departments.id','=','attendances.department')
        ->where('attendances.business',$business)->get([
            'attendances.id AS no',
            'business_admins.fullname AS employeeName',
            'business_admins.photo AS employeePhoto',
            'department.name AS department',
            'attendances.created_at AS created_at']);

        return response()->json([
            'data' => $attendance
        ]);
    }
}
