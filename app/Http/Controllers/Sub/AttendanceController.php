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
        $attendance = Attendance::where('business',$business)->get();

        return response()->json([
            'data' => $attendance
        ]);
    }
}
