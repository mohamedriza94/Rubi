<?php

namespace App\Http\Controllers\Rubi;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Business;

class BusinessController extends Controller
{
    public function read($limit, $status)
    {
        switch ($status) {
            case 'all':
                $businesses = Business::orderBy('id')
                ->limit(12)->offSet($limit)->get();
                return response()->json(['data' => $businesses]);
                break;
                
                default:
                $businesses = Business::where('status',$status)->orderBy('id')
                ->limit(12)->offSet($limit)->get();
                return response()->json(['data' => $businesses]);
                break;
            }
    }

    public function search($search, $limit, $status)
    {
        switch ($status) {
            case 'all':
                $businesses = Business::orderBy('id')->where('name','Like','%'.$search.'%')
                ->limit(12)->offSet($limit)->get();
                return response()->json(['data' => $businesses]);
                break;
                
                default:
                $businesses = Business::where('status',$status)->where('name','Like','%'.$search.'%')
                ->orderBy('id')
                ->limit(12)->offSet($limit)->get();
                return response()->json(['data' => $businesses]);
                break;
            }
    }

    public function readOne($id)
    {
        $businesses = Business::where('id',$id)->first();
        return response()->json(['data' => $businesses]);
    }

    public function updateStatus(Request $request)
    {
        DB::beginTransaction();
        try 
        {
            $id = $request->input('id');
            
            //get current status
            $business = Business::where('id', $id)->first(); 
            $currentStatus = $business->status;

            switch ($currentStatus) {
                case 'active':
                    Business::where('id', $id)->update(['status' => 'inactive']); 
                break;
                case 'inactive':
                    Business::where('id', $id)->update(['status' => 'active']); 
                break;
            }

            DB::commit();
        } 
        catch (\Exception $e) 
        {
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Failure. Try again']);
        }
        return response()->json(['status' => 200, 'message' => 'Status Changed']);
    }
}
