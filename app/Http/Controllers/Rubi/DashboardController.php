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
        
        $businessesCountByMonth = Business::query()
        ->selectRaw('COUNT(*) as count, MONTHNAME(created_at) as month')
        ->groupBy('month')->get(); //Chart

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
