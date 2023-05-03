<?php

namespace App\Http\Controllers\Rubi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        
        $businessesCountByMonth = Business::select(DB::raw("DATE_FORMAT(created_at,'%M %Y') as monthYear"), DB::raw("COUNT(*) as count"))
        ->groupBy('monthYear')
        ->get();

        //get today business registrations
        $todayRegistration = Business::where('status','active')->whereDate('created_at', today())->get();
        
        return response()->json([
            'totalBusiness' => $totalBusiness,
            'activeBusiness' => $activeBusiness,
            'TodayBusinessRegistrations' => $TodayBusinessRegistrations,
            'totalPendingInquiries' => $totalPendingInquiries,
            'businessesCountByMonth' => $businessesCountByMonth,
            'todayRegistration' => $todayRegistration
        ]);
    }

    public function notification()
    {
        $pendingInquiryCount = Inquiry::where('status','unread')->where('is_deleted','0')->count();
        $pendingInquiries = Inquiry::where('status','unread')->where('is_deleted','0')->orderBy('id','DESC')->limit(4)->get();
            

        return response()->json([
            'pendingInquiryCount' => $pendingInquiryCount,
            'pendingInquiries' => $pendingInquiries
        ]);
    }
}
