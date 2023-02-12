<?php

namespace App\Http\Controllers\Rubi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\Inquiry;
use App\Models\Message;
use App\Models\Reply;


class MessageController extends Controller
{
    public function readMessages($type,$limit)
    {
        $inboxCount = Inquiry::where('status','unread')->where('is_deleted','0')->count();
        
        switch ($type) {
            case 'inbox'
            :
            
            $inquiries = Inquiry::orderBy('id','DESC')->where('is_deleted','0')->limit(12)->offSet($limit)->get();
            return response()->json(['data' => $inquiries,'count' => $inboxCount]);
            
            break;
            case 'starred'
            :
            
            $inquiries = Inquiry::where('is_starred','1')->where('is_deleted','0')->orderBy('id','DESC')->limit(12)->offSet($limit)->get();
            return response()->json(['data' => $inquiries,'count' => $inboxCount]);
            
            break;
            case 'trash'
            :
            
            $inquiries = Inquiry::orderBy('id','DESC')->where('is_deleted','1')->limit(12)->offSet($limit)->get();
            return response()->json(['data' => $inquiries,'count' => $inboxCount]);

            break;
            case 'replies'
            :
            break;
            case 'sent'
            :

            $messages = Message::orderBy('id','DESC')->limit(12)->offSet($limit)->get([
                'id AS id', 'email AS name', 'subject AS subject', 'message AS message', 'created_at AS created_at'
            ]);

            $messages = $messages->map(function ($item) {
                $item['status'] = '-'; $item['is_starred'] = '-'; $item['is_deleted'] = 3; return $item;
            });
            return response()->json(['data' => $messages,'count' => $inboxCount]);

            break;
        }
    }
    
    public function starMessage($id, $status)
    {
        DB::beginTransaction();
        try {
            
            Inquiry::where('id', $id)->update(['is_starred' => $status]);
            DB::commit();
            
        } catch (\Exception $e) {
            
            DB::rollBack();
        }
    }
    
    public function moveToTrash(Request $request, $type)
    {
        DB::beginTransaction();
        try 
        {
            $ids = $request->input('ids');
            $message = '';
            switch ($type) {
                case 'sent':
                    Message::whereIn('id', $ids)->delete(); //DELETE SENT MESSAGES
                    $message = 'Deleted messages';
                break;
                case 'inbox':
                    Inquiry::whereIn('id', $ids)->update(['is_deleted' => '1']); //MOVE RECEIVED MESSAGES TO TRASH
                    $message = 'Moved messages to trash';
                break;
                case 'trash':
                    Inquiry::whereIn('id', $ids)->delete(); //DELETE INQUIRIES PERMANENTLY
                    $message = 'Deleted Inquiries';
                break;
            }
            DB::commit();
        } 
        catch (\Exception $e) 
        {
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Failure. Try again']);
        }
        return response()->json(['status' => 200, 'message' => 'Deleted']);
    }

    public function sendMessage(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [     
                'email' => 'required|email',
                'subject' => 'required|max:60',
                'message' => 'required',
            ], [
                'email.required' => 'Email is required',
                'email.email' => 'Email is not in the correct format',
                'subject.required' => 'Subject is required',
                'subject.max' => 'Subject cannot exceed 60 characters',
                'message.required' => 'Message is required',
            ]);
            
            if ($validator->fails()) { 
                return response()->json([
                    'status'=>600,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
                Message::create([
                    'email' => $request->input('email'),
                    'subject' => $request->input('subject'),
                    'message' => $request->input('message'),
                ]);
                
                //Send Email
                $data["email"] = $request->input('email');
                $data["subject"] = $request->input('subject');
                $data["messageDescription"] = $request->input('message');
                Mail::send('mail.messageMail', $data, function($message)use($data) {
                    $message->to($data["email"])
                    ->subject($data["subject"]);
                });
                DB::commit();
            }
            
        } catch (\Exception $e) {
            
            DB::rollBack();
            return response()->json([
                'status'=>400,
                'message'=>'Could not send message, Check your internet connection and Try again'
            ]);
        }
        
        return response()->json([
            'status'=>200
        ]);
    }

    public function seeMessage($id)
    {
        DB::beginTransaction();
        try 
        {
            Inquiry::where('id', $id)->update(['status' => 'read']);
            DB::commit();
            
        } catch (\Exception $e) {
            
            DB::rollBack();
        }
        $inquiry = Inquiry::find($id);
        return response()->json(['data' => $inquiry]);
    }
}
