<?php

namespace App\Http\Controllers\sub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\Application;
use App\Models\Business;

class ApplicationController extends Controller
{
    public function search($search)
    {
        $applications = Application::join('vacancies','applications.vacancy','=','vacancies.id')
        ->where('vacancies.position','Like','%'.$search.'%')
        ->where('vacancies.business',auth()->guard('businessAdmin')->user()->business)->orderBy('id','DESC')->get([
            'applications.id AS id',
            'applications.name AS name',
            'applications.email AS email',
            'applications.status AS status',
            'vacancies.position AS vacancy'
        ]);
        return response()->json(['data' => $applications]);
    }

    public function read()
    {
        $applications = Application::join('vacancies','applications.vacancy','=','vacancies.id')
        ->where('vacancies.business',auth()->guard('businessAdmin')->user()->business)->orderBy('id','DESC')->get([
            'applications.id AS id',
            'applications.name AS name',
            'applications.email AS email',
            'applications.status AS status',
            'vacancies.position AS vacancy'
        ]);
        return response()->json(['data' => $applications]);
    }

    public function sort($type)
    {
        $applications = Application::join('vacancies','applications.vacancy','=','vacancies.id')
        ->where('vacancies.business',auth()->guard('businessAdmin')->user()->business)
        ->where('applications.status',$type)
        ->orderBy('id','DESC')->get([
            'applications.id AS id',
            'applications.name AS name',
            'applications.email AS email',
            'applications.status AS status',
            'vacancies.position AS vacancy'
        ]);
        return response()->json(['data' => $applications]);
    }

    public function readOne($id)
    {
        $application = Application::find($id);
        return response()->json(['data' => $application]);
    }
    
    public function shortlist(Request $request)
    {
        DB::beginTransaction();
        try 
        {
            $id = $request->input('id');
            
            Application::where('id', $id)->update(['status' => 'shortlisted']);

            //get application details
            $application = Application::find($id);

            //get business details
            $authUser = auth()->guard('businessAdmin')->user();
            $business = Business::find($authUser->business);

            // send Mail
            $data["email"] = $application->email;
            $data["title"] = "APPLICATION SHORTLISTED";
            $data["note"] = $request->input('note');
            $data["business"] = $business->name;
            $data["fromEmail"] = $business->email;
            Mail::send('mail.applicationStatusMail', $data, function($message)use($data) {
                $message->from($data["fromEmail"])->to($data["email"])
                ->subject($data["title"]);
            });
            
            DB::commit();
        } 
        catch (\Exception $e) 
        {
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Failure. Try again']);
        }
        return response()->json(['status' => 200, 'message' => 'Application Shortlisted']);
    }
    
    public function reject(Request $request)
    {
        DB::beginTransaction();
        try 
        {
            $id = $request->input('id');
            
            Application::where('id', $id)->update(['status' => 'rejected']);

            //get application details
            $application = Application::find($id);

            //get business details
            $authUser = auth()->guard('businessAdmin')->user();
            $business = Business::find($authUser->business);

            // send Mail
            $data["email"] = $application->email;
            $data["title"] = "APPLICATION REJECTION";
            $data["note"] = $request->input('note');
            $data["business"] = $business->name;
            $data["fromEmail"] = $business->email;
            Mail::send('mail.applicationStatusMail', $data, function($message)use($data) {
                $message->from($data["fromEmail"])->to($data["email"])
                ->subject($data["title"]);
            });
            
            DB::commit();
        } 
        catch (\Exception $e) 
        {
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Failure. Try again']);
        }
        return response()->json(['status' => 200, 'message' => 'Application Shortlisted']);
    }
}
