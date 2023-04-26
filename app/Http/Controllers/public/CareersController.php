<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Vacancy;
use App\Models\Application;

class CareersController extends Controller
{
    public function readOne()
    {
        $vacancy = Vacancy::where('status', 'active')->orderBy('id', 'DESC')->get();
        return response()->json(['data' => $vacancy]);
    }

    public function applyJobPOST(Request $request)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'vacancy' => 'required',
                'name' => 'required|string',
                'email' => 'required|email',
                'telephone' => 'required',
                'cv' => 'required|mimes:pdf|max:8192',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            } else {
                //generate PDF path
                $cvPath = request('cv')->store('cv', 'public');
                $cv = '/'.'storage/'.$cvPath;

                Application::create(['vacancy' => $request->input('vacancy'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'telephone' => $request->input('telephone'),
                'coverLetter' => $request->input('coverLetter'),
                'cv' => $cv,
                'status' => 'pending']);

                // Commit the transaction if everything goes well
                DB::commit();
            }

        } catch (\Exception $e) {

            // An exception occured, rollback the transaction
            DB::rollBack();

            // Return an error message to the view
            return redirect()->back()->with('error', 'Something\'s Wrong. Please retry in a while: '. $e->getMessage());
        }

        // Return success message to the view
        return redirect()->back()->with('success', 'Application Sent! You will receive a response soon.');
    }
}