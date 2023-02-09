<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    //for password resetting
    public function sendOtp($email)
    {
        DB::beginTransaction();
        
        try 
        {
            // Generate OTP
            $otp = rand(100000, 999999);
            
            // Store OTP and its expiry time in the database
            DB::table('password_resets')->insert([
                'email' => $email,
                'otp' => $otp,
                'created_at' => Carbon::now()
            ]);
            
            // Send the OTP to the user's email
            $data["email"] = $email;
            $data["title"] = "Password Reset";
            $data["otp"] = $otp;
            
            Mail::send('mail.otp', $data, function($message)use($data) {
                $message->to($data["email"])
                ->subject($data["title"]);
            });
            
            DB::commit();
        }
        catch (\Exception $e) 
        {
            DB::rollBack();
            
            //return response
            $message = 'Could not send OTP. Try again later';//.$e->getMessage();
            return [
                'message' => $message
            ];
        }
        
        //return response
        $message = 'success';
        return [
            'message' => $message
        ];
    }
    public function verifyOtp($email, $otp)
    {
        // Retrieve the OTP from the database
        $otpData = DB::table('password_resets')
        ->where('email', $email)
        ->first();
        
        // Check if the OTP has expired
        if (Carbon::parse($otpData->created_at)->addMinutes(10)->isPast()) 
        {
            //return response
            $message = 'OTP has expired. Get a new one';
            return [ 'message' => $message ];
        }
        
        // Verify the OTP entered by the user
        if ($otpData->otp == $otp) {

            // Delete the OTP from the database
            DB::table('password_resets')->where('email', $email)->delete();
            
            //return response
            $message = 'success';
            return [ 'message' => $message ];
        } 
        else 
        {
            //return response
            $message = 'Invalid OTP';
            return [ 'message' => $message ];
        }
    }
}
