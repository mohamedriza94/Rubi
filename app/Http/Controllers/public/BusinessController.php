<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Business;
use App\Http\Controllers\common\CommonController;
use Carbon\Carbon;

class BusinessController extends Controller
{
    public function registrationPOST(Request $request)
    {
        // Start a database transaction
        DB::beginTransaction();
        
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [     
                'name' => 'required|max:255',
                'type' => 'required|max:255',
                'product' => 'required|max:255',
                'email' => 'required|max:255|unique:businesses',
                'country' => 'required|max:50',
                'logo' => 'required|image|mimes:jpeg,png',
            ], [
                'name.required' => 'Name is required',
                'type.required' => 'Choose a Business type',
                'product.numeric' => 'Choose a phone',
                'email.required' => 'Email is required',
                'country.required' => 'Choose a country',
                'logo.required' => 'Logo is required',
                'logo.mimes' => 'Image should either be a JPG or PNG',
            ]);
            
            if ($validator->fails()) { 
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            }
            else
            {
                //generate a business no
                $no = mt_rand();
                $exists = Business::where('no', $no)->exists();
                while ($exists) {
                    $no = mt_rand();
                    $exists = Business::where('no', $no)->exists();
                }
                
                //generate photo path
                $photoPath = request('logo')->store('business','public');
                $photo = '/'.'storage/'.$photoPath;
                $delimiter = "/"; //to split the array
                $array = explode($delimiter, $photoPath); 
                $editedPhotoPath = $array[1];
                
                // Perform database operation
                Business::create([
                    'name' => $request->input('name'),
                    'type' => $request->input('type'),
                    'product' => $request->input('product'),
                    'email' => $request->input('email'),
                    'website' => $request->input('website'),
                    'country' => $request->input('country'),
                    'photo' => $photo,
                    'photoPath' => $editedPhotoPath,
                    'no' => $no,
                    'status' => 'unverified'
                ]);
                
                //Send Verification Email
                $data["email"] = $request->input('email');
                $data["title"] = "Business Verification";
                $data["businessNo"] = $no;
                $data["name"] = $request->input('name');
                
                Mail::send('mail.businessVerificationMail', $data, function($message)use($data) {
                    $message->to($data["email"])
                    ->subject($data["title"]);
                });
                
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
        return redirect()->back()->with('success', 'Verify your business from the link that was sent to your Email');
    }
    
    public function verifyBusiness($businessNo)
    {
        // Start a database transaction
        DB::beginTransaction();
        
        try {
            //check if an unverified business account in this business number exists
            $exists = Business::where('no', $businessNo)->where('status', 'unverified')->exists();
            if($exists)
            {
                $verifiedDate = NOW();
                $password = Str::random(10); //generate password
                $hashedPassword = Hash::make($password);
                
                Business::where('no', $businessNo)->update([
                    'status' => 'active',
                    'verifiedDate' => $verifiedDate,
                    'password' => $hashedPassword
                ]);
                
                //get business details
                $business = Business::where('no', $businessNo)->first();
                //Send Activation Confirmation Email
                $data["email"] = $business['email'];
                $data["title"] = "Business Verified";
                $data["businessNo"] = $businessNo;
                $data["password"] = $password;
                
                Mail::send('mail.businessActivationConfirmationMail', $data, function($message)use($data) {
                    $message->to($data["email"])
                    ->subject($data["title"]);
                });
                
                DB::commit();
            }
            else
            {
                $message = "THIS ACCOUNT HAS ALREADY BEEN VERIFIED";
                $message2 = "";
                $title = "Verified";
                return view('client.verification')->with('message', $message)->with('message2', $message2)->with('title', $title);
            }
            
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Something\'s Wrong. Please retry in a while: '. $e->getMessage());
        }
        
        $message = "YOUR ACCOUNT HAS BEEN VERIFIED SUCCESSFULLY :)";
        $message2 = "You will receive your signin credentials in an Email, shortly. Thank you.";
        $title = "Verification";
        return view('client.verification')->with('message', $message)->with('message2', $message2)->with('title', $title);
    }
    
    public function verifyEmailAndSendOTP(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [     
            'email' => 'required|email'
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'This should be an Email',
        ]);
        
        if ($validator->fails()) { 
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            //check whether an active business with this email exists
            $exists = Business::where('email', $request->input('email'))->where('status', 'active')->exists();
            
            if ($exists) 
            {
                $commonController = new CommonController();
                $result = $commonController->sendOtp($request->input('email'));
                
                $message = $result['message'];
                
                if ($message != 'success') {
                    return redirect()->back()->with('error', $message);
                } else {
                    $title = "Reset Password";
                    return redirect()->route('client.resetPassword', [ //redirect with get method
                        'title' => $title,
                        'email' => $request->input('email'),
                    ]);
                }
            }
            else
            {
                return redirect()->back()->with('error', 'This Email has not been registered. Please enter a valid Email');
            }
        }
    }
    
    public function resetPassword(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [     
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'otp' => 'required'
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'This should be an Email',
            'otp.required' => 'OTP is required'
        ]);
        
        if ($validator->fails()) { 
            return redirect()->back()->withErrors($validator)->withInput();
            return view('client.resetPassword')->with('title', $title)->with('email', $request->input('email'));
        }
        else
        {
            //check whether an active business with this email exists
            $exists = Business::where('email', $request->input('email'))->where('status', 'active')->exists();
            
            if ($exists) 
            {
                $commonController = new CommonController();
                $result = $commonController->verifyOtp($request->input('email'),$request->input('otp'));
                
                $message = $result['message'];
                
                if ($message != 'success') 
                {
                    return redirect()->back()->with('error', $message);
                }
                else 
                {
                    DB::beginTransaction();
                    try 
                    {
                        //if OTP has been verified
                        $hashedPassword = Hash::make($request->input('password'));
                        
                        Business::where('email', $request->input('email'))->update([
                            'password' => $hashedPassword
                        ]);
                        
                        DB::commit();
                    } 
                    catch (\Exception $e) 
                    {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Something\'s Wrong. Try Again Later: '. $e->getMessage());
                    }
                    return redirect()->back()->with('success', 'Password Changed Succesfully');
                }
            }
            else
            {
                return redirect()->back()->with('error', 'The Email is invalid');
            }
        }
    }
}
