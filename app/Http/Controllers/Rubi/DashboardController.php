<?php

namespace App\Http\Controllers\Rubi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\Inquiry;

class DashboardController extends Controller
{
    public function readCount()
    {
        $totalBusiness = Business::where('status','!=','unverified')->count();
        $activeBusiness = Business::where('status','active')->count();
        $TodayBusinessRegistrations = Business::where('status','active')->whereDate('created_at', today())->count();
        $totalPendingInquiries = Inquiry::where('status','unread')->where('is_deleted','0')->count();
        
        return response()->json([
            'totalBusiness' => $totalBusiness,
            'activeBusiness' => $activeBusiness,
            'TodayBusinessRegistrations' => $TodayBusinessRegistrations,
            'totalPendingInquiries' => $totalPendingInquiries,
        ]);
    }
}
