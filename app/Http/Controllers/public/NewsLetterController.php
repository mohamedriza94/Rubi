<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\NewsLetterSubscriber;

class NewsLetterController extends Controller
{
    
    public function newsLetterSubscribe(Request $request)
    {
        // Start a database transaction
        DB::beginTransaction();
        
        try {
            
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:new_letter_subscribers',
            ], [
                'email.required' => 'Email is required',
                'email.email' => 'This should be an Email',
                'email.unique' => 'You\'re already subscribed',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            }
            else
            {
                // Perform database operation
                NewsLetterSubscriber::create([
                    'email' => $request->input('email'),
                    'status' => 'active',
                ]);
                
                // Commit the transaction if everything goes well
                DB::commit();
            }
            
        } catch (\Exception $e) {
            
            // An exception occured, rollback the transaction
            DB::rollBack();
            
            // Return an error message to the view
            return redirect()->back()->with('errorNewsLetter', 'Something\'s Wrong. Please retry in a while: '. $e->getMessage());
        }
        
        // Return success message to the view
        return redirect()->back()->with('successNewsLetter', 'Subscribed!');
    }
}
