<?php

namespace App\Http\Controllers\Rubi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Business;

class ActivityController extends Controller
{
    public function read($limit)
    {
        $activities = Activity::join('businesses','activities.user','=','businesses.id')->
        where('activities.userType','business')->orderBy('activities.id')->limit(12)->offSet($limit)
        ->get([
            'businesses.name AS business',
            'businesses.photo AS logo',
            'activities.activity AS activity',
            'activities.created_at AS created_at',
        ]);

        return response()->json(['data' => $activities]);
    }
    
    public function search($search, $limit)
    {
        $activities = Activity::join('businesses','activities.user','=','businesses.id')->
        where('activities.userType','business')
        ->orderBy('activities.id')->where('businesses.name','Like','%'.$search.'%')->limit(12)->offSet($limit)
        ->get([
            'businesses.name AS business',
            'businesses.photo AS logo',
            'activities.activity AS activity',
            'activities.created_at AS created_at',
        ]);

        return response()->json(['data' => $activities]);
    }
}
