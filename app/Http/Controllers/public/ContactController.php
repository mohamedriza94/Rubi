<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Inquiry;

class ContactController extends Controller
{
    public function contactPOST(Request $request)
    {
        // Start a database transaction
        DB::beginTransaction();
        
        try {
            
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'number' => 'required|numeric',
                'email' => 'required|email',
                'subject' => 'required|max:255',
                'message' => 'required',
            ], [
                'name.required' => 'Name is required',
                'number.required' => 'Phone Number is required',
                'number.numeric' => 'Phone Number can contain only numbers',
                'email.required' => 'Email is required',
                'subject.required' => 'Subject is required',
                'message.required' => 'Message is required',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            }
            else
            {
                // Perform database operation
                Inquiry::create([
                    'name' => $request->input('name'),
                    'number' => $request->input('number'),
                    'email' => $request->input('email'),
                    'subject' => $request->input('subject'),
                    'message' => $request->input('message'),
                    'status' => 'unread',
                    'is_starred' => '0',
                    'is_deleted' => '0'
                ]);
                
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
        return redirect()->back()->with('success', 'Your Inquiry Was Sent. Await a Reply into Your Email');
    }
}
