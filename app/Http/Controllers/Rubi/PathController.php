<?php

namespace App\Http\Controllers\Rubi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PathController extends Controller
{
    public function dashboard()
    {
        $view_data['title'] = 'Dashboard'; $view_data['brand'] = 'Rubi';
        return view('rubi.dashboard.index')->with($view_data);
    }

    public function messages()
    {
        $view_data['title'] = 'Messages'; $view_data['brand'] = 'Rubi';
        return view('rubi.dashboard.messages')->with($view_data);
    }

    public function packages()
    {
        $view_data['title'] = 'Packages'; $view_data['brand'] = 'Rubi';
        return view('rubi.dashboard.packages')->with($view_data);
    }
}
