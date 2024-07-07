<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\User;
// use App\Models\Responsibility;
// use App\Models\Supply;

class UserController extends Controller
{
    public function index()
    {
        $obj = User::orderBy('first_name', 'ASC')->get();
        return response(['data' => $personnel, 'message' => 'personnel data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function getById($id)
    {
        $personnel = Personnel::find($id);
        if(!empty($personnel)){
            return response(['data' => $personnel, 'message' => 'single personnel data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to get personnel data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

    public function getResponsibilities($id)
    {
        $personnel = Personnel::find($id);

        if(!empty($personnel->id)){
            $responsibility = Responsibility::where('personnel_id' , '=',$personnel->id)->get();

            if(!empty($responsibility)){
                return response(['data' => $responsibility, 'message' => "get personnel responsibilities", 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
            }else{
                return response(['data' => [], 'message' => 'unable to get personnel responsibilities', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
            }
        }else{
            return response(['data' => [], 'message' => 'unable to get personnel responsibilities by id', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
        
    }
    
    public function getSupplies($id)
    {
        $personnel = Personnel::find($id);

        if(!empty($personnel->id)){
            $supply = Supply::where('personnel_id' , '=',$personnel->id)->get();

            if(!empty($supply)){
                return response(['data' => $supply, 'message' => "get personnel supply", 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
            }else{
                return response(['data' => [], 'message' => 'unable to get personnel supply', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
            }
        }else{
            return response(['data' => [], 'message' => 'unable to get personnel responsibilities by id', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
        
    }

    public function getSupply($id)
    {
        $personnel = Personnel::find($id);
        if(!empty($personnel)){
            return response(['data' => $personnel, 'message' => 'single personnel data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to get personnel data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required',
            'telephone'  => 'required',
            'age'        => 'required',
            'sex'        => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();

        $first_name = $input['first_name'];
        $last_name = $input['last_name'];
        $email = $input['email'];
        $telephone = $input['telephone'];
        $age = $input['age'];
        $sex = $input['sex'];

        $personnelObj = Personnel::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'age' => $age,
            'telephone' => $telephone,
            'sex' => $sex,
            'created_at' => Carbon::now(),
        ]);
        $saved = $personnelObj->save();

        return response(['data' => $personnelObj, 'message' => 'created personnel data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_CREATED')]);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required',
            'telephone'  => 'required',
            'age'        => 'required',
            'sex'        => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();

        $first_name = $input['first_name'];
        $last_name = $input['last_name'];
        $email = $input['email'];
        $telephone = $input['telephone'];
        $age = $input['age'];
        $sex = $input['sex'];

        $personnel = Personnel::find($id);
        if(empty($personnel)){
            return response(['data' => [], 'message' => 'unable to update personnel data, invalid id', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
        $personnel->first_name = $first_name;
        $personnel->last_name = $last_name;
        $personnel->email = $email;
        $personnel->telephone = $telephone;
        $personnel->age = $age;
        $personnel->sex = $sex;
        $personnel->updated_at = Carbon::now();
        $saved = $personnel->save();
        
        return response(['data' => $personnel, 'message' => 'single personnel data updated', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function delete($id)
    {
        $personnel = Personnel::find($id);
        if(!empty($personnel)){
            $personnel->delete();
            return response(['data' => $personnel, 'message' => 'personnel data deleted', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to delete personnel data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

}