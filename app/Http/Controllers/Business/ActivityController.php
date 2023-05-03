<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function read($limit)
    {
        $userData = auth()->guard('business')->user();

        $data = Activity::join('business_admins','activities.user','=','business_admins.id')
        ->join('businesses','business_admins.business','=','businesses.id')
        ->where('businesses.id',$userData->id)
        ->where('activities.userType','!=','business')
        ->orderby('activities.id','DESC')
        ->limit(12)->offSet($limit)->get([
            'business_admins.fullname AS user',
            'business_admins.photo AS userPhoto',
            'business_admins.id AS userID',
            'activities.created_at AS created_at',
            'activities.activity AS activity',
            'activities.userType AS userType',
        ]);

        return response()->json([
            'data'=>$data
        ]);
    }

    public function search($search, $limit)
    {
        $userData = auth()->guard('business')->user();

        $data = Activity::join('business_admins','activities.user','=','business_admins.id')
        ->join('businesses','business_admins.business','=','businesses.id')
        ->where('businesses.id',$userData->id)
        ->where('activities.userType','!=','business')
        ->where('business_admins.fullname','Like','%'.$search.'%')
        ->orderby('activities.id','DESC')
        ->limit(12)->offSet($limit)->get([
            'business_admins.fullname AS user',
            'business_admins.photo AS userPhoto',
            'business_admins.id AS userID',
            'activities.created_at AS created_at',
            'activities.activity AS activity',
            'activities.userType AS userType',
        ]);

        return response()->json([
            'data'=>$data
        ]);
    }
}
