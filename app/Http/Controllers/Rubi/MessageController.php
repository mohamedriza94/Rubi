<?php

namespace App\Http\Controllers\Rubi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inquiry;

class MessageController extends Controller
{
    public function readMessages($type,$limit)
    {
        $inboxCount = Inquiry::where('status','unread')->count();

        switch ($type) {
            case 'inbox'
            :
            
            $inquiries = Inquiry::orderBy('id','DESC')->limit(12)->offSet($limit)->get();
            return response()->json(['data' => $inquiries,'count' => $inboxCount]);
            
            break;
            case 'starred'
            :
            
            $inquiries = Inquiry::where('is_starred','1')->orderBy('id','DESC')->limit(12)->offSet($limit)->get();
            return response()->json(['data' => $inquiries]);
            
            break;
            case 'trash'
            :
            break;
            case 'replies'
            :
            break;
            case 'sent'
            :
            break;
        }
    }
    
    public function starMessage($id, $status)
    {
        DB::beginTransaction();
        
        try {

            Inquiry::where('id', $id)->update(['is_starred' => $status]);
            DB::commit();
            return response()->json(['status' => 200]);
            
        } catch (\Exception $e) {
            
            DB::rollBack();
            return response()->json(['status' => 400]);
        }
        
    }
}
