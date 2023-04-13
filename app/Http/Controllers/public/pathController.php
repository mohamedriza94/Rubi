<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vacancy;

class pathController extends Controller
{
    public function home() 
    {
        $title = "Home";
        return view('client.home')->with('title', $title);
    }
    
    public function contact() 
    {
        $title = "Contact Us";
        return view('client.contact')->with('title', $title);
    }
    
    public function about() 
    {
        $title = "About Us";
        return view('client.about')->with('title', $title);
    } 

    public function careers() 
    {
        $vacancies = Vacancy::where('status', 'active')->orderBy('id', 'DESC')->get();
        $title = "Careers";
        return view('client.careers', [
            'title' => $title,
            'vacancies' => $vacancies,
        ]);
    }
    
    public function signin() 
    {
        $title = "Business Signin";
        return view('client.signin')->with('title', $title);
    }
    
    public function registration() 
    {
        $title = "Business Registration";
        return view('client.registration')->with('title', $title);
    }
    
    public function forgotPassword() 
    {
        $title = "Forgot Password";
        return view('client.forgotPassword')->with('title', $title);
    }
    
    public function jobDetails($id) 
    {
        $vacancies = Vacancy::where('status', 'active')->orderBy('id', 'DESC')->get();
        $vacancy = Vacancy::find($id);
        $title = "Job Details";
        return view('client.jobDetails', [
            'title' => $title,
            'vacancy' => $vacancy,
            'vacancies' => $vacancies
        ]);
    }
    
    public function registrationStepTwo() 
    {
        $title = "Business Registration";
        return view('client.registrationStepTwo')->with('title', $title);
    }
}
