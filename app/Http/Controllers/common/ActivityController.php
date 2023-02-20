<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function recordActivity($data)
    {
        $activity = new Activity;
        $activity->userType = $data['userType'];
        $activity->activity = $data['activity'];
        $activity->user = $data['user'];
        $activity->save();
    }
}
