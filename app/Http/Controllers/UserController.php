<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
// use App\Models\Supply;

class UserController extends Controller
{
    public function index()
    {
        $obj = User::orderBy('email', 'ASC')->get();
        return response(['data' => $obj, 'message' => 'user data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function getById($id)
    {
        $obj = User::find($id);
        if(!empty($obj)){
            return response(['data' => $obj, 'message' => 'single user data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to get user data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

    public function orders($id)
    {
        $obj = Order::Where('user_id', $id)->get();

        if(!empty($obj)){
            return response(['data' => $obj, 'message' => "get user orders", 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to get user orders', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
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

    public function edit(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'first_name'        => 'required',
            'last_name'         => 'required',
            'email'             => 'required',
            'address'           => 'required',
            'phone_number'      => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();

        $first_name = $input['first_name'];
        $last_name = $input['last_name'];
        $email = $input['email'];
        $address = $input['address'];
        $phone_number = $input['phone_number'];

        $obj = User::find($id);
        if(empty($obj)){
            return response(['data' => [], 'message' => 'unable to update user data, invalid id', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
        $obj->first_name = $first_name;
        $obj->last_name = $last_name;
        $obj->email = $email;
        $obj->address = $address;
        $obj->phone_number = $phone_number;
        $obj->updated_at = Carbon::now();
        $saved = $obj->save();
        
        return response(['data' => $obj, 'message' => 'single user data updated', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function delete($id)
    {
        $obj = User::find($id);
        if(!empty($obj)){
            $obj->delete();
            return response(['data' => $obj, 'message' => 'user data deleted', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to user user data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

}