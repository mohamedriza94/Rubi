<?php

namespace App\Http\Controllers\Rubi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Package;

class PackageController extends Controller
{
    public function read($limit)
    {
        $packages = Package::orderBy('id','DESC')->where('is_deleted','0')->limit(12)->offSet($limit)->get();
        return response()->json(['data' => $packages]);
    }
    
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [     
                'description' => 'required',
                'price' => 'required|numeric|min:0',
                'periodDuration' => 'required|numeric',
                'periodUnit' => 'required',
                'name' => 'required',
                'status' => 'required|string',
                'photo' => 'required|image|max:2048',
            ], [
                'description.required' => 'Description is required',
                'price.required' => 'Price is required', 'price.numeric' => 'Price should be a number',
                'periodDuration.required' => 'Enter the package\'s duration', 'periodDuration.numeric' => 'Package duration should be a number',
                'periodUnit.required' => 'Choose the package\'s unit',
                'name.required' => 'Name is required',
                'status.required' => 'Status is required',
                'photo.required' => 'Photo is required', 'photo.image' => 'Photo must be an image',
            ]);
            
            if ($validator->fails()) { 
                return response()->json([
                    'status'=>600,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
                $photo = ''; $editedPhotoPath = '';
                if(request('photo')!="")
                {
                    //generate photo path
                    $photoPath = request('photo')->store('packages','public');
                    $photo = '/'.'storage/'.$photoPath;
                    $delimiter = "/"; //to split the array
                    $array = explode($delimiter, $photoPath); 
                    $editedPhotoPath = $array[1];
                }

                Package::create([ 'description' => $request->input('description'), 
                'price' => $request->input('price'), 
                'periodDuration' => $request->input('periodDuration'),
                'periodUnit' => $request->input('periodUnit'), 
                'name' => $request->input('name'), 
                'is_deleted' => '0', 
                'status' => $request->input('status'),  
                'photo' => $photo,
                'photoPath' => $editedPhotoPath]);

                DB::commit();
            }
            
        } catch (\Exception $e) {
            
            DB::rollBack();
            return response()->json([
                'status'=>400,
                'message'=>'Could not create package. Try again'
            ]);
        }
        
        return response()->json([
            'status'=>200
        ]);
    }

    public function readOne($id)
    {
        $package = Package::find($id);
        return response()->json(['data' => $package]);
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try 
        {
            $id = $request->input('id');
            Package::where('id', $id)->update(['is_deleted' => '1']); 
            DB::commit();
        } 
        catch (\Exception $e) 
        {
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Failure. Try again']);
        }
        return response()->json(['status' => 200, 'message' => 'Deleted']);
    }

    public function updateStatus(Request $request)
    {
        DB::beginTransaction();
        try 
        {
            $id = $request->input('id');
            
            //get current status
            $package = Package::where('id', $id)->first(); 
            $currentStatus = $package->status;

            switch ($currentStatus) {
                case 'active':
                    Package::where('id', $id)->update(['status' => 'inactive']); 
                break;
                case 'inactive':
                    Package::where('id', $id)->update(['status' => 'active']); 
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
    
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [     
                'id' => 'exists:packages,id|required',
                'description' => 'required',
                'price' => 'required|numeric|min:0',
                'periodDuration' => 'required|numeric',
                'periodUnit' => 'required',
                'name' => 'required',
                //'photo' => 'image|max:2048',
            ], [
                'description.required' => 'Description is required',
                'price.required' => 'Price is required', 'price.numeric' => 'Price should be a number',
                'periodDuration.required' => 'Enter the package\'s duration', 'periodDuration.numeric' => 'Package duration should be a number',
                'periodUnit.required' => 'Choose the package\'s unit',
                'name.required' => 'Name is required',
                //'photo.image' => 'Photo must be an image',
            ]);
            
            if ($validator->fails()) { 
                return response()->json([
                    'status'=>600,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
                $id = $request->input('id');
                $photo = ''; $editedPhotoPath = '';
                $package = Package::where('id', $id)->first(); //get photo and photo path
                if(request('photo')!="")
                {
                    //delete current photo
                    $photoName = basename($package->photoPath);
                    $currentPhoto = public_path('packages/'.$photoName); //get photo path
                    
                    if (File::exists($currentPhoto)) { //delete current photo
                        File::delete($currentPhoto);
                    }
                    
                    //generate photo path
                    $photoPath = request('photo')->store('packages','public');
                    $photo = '/'.'storage/'.$photoPath;
                    $delimiter = "/"; //to split the array
                    $array = explode($delimiter, $photoPath); 
                    $editedPhotoPath = $array[1];
                }
                else 
                {
                    $photo = $package->photo;
                    $editedPhotoPath = $package->photoPath;
                }

                Package::where('id', $id)->update([ 'description' => $request->input('description'), 
                'price' => $request->input('price'), 
                'periodDuration' => $request->input('periodDuration'),
                'periodUnit' => $request->input('periodUnit'), 
                'name' => $request->input('name'), 
                'photo' => $photo,
                'photoPath' => $editedPhotoPath]);

                DB::commit();
            }
            
        } catch (\Exception $e) {
            
            DB::rollBack();
            return response()->json([
                'status'=>400,
                'message'=>'Could not update package. Try again'
            ]);
        }
        
        return response()->json([
            'status'=>200
        ]);
    }
}
