<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\PersonalAccessToken;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Constraint\RelatedTo;
// use Lcobucci\JWT\Validation\Validator;

class UserController extends Controller
{
    private function generateToken($obj){
        $tokenBuilder = (new Builder(new JoseEncoder(), ChainedFormatter::default()));
        $algorithm    = new Sha256();
        $signingKey   = InMemory::plainText(Hash::make(env('JWT_KEY')));

        $now   = Carbon::now()->toImmutable();
        $token = $tokenBuilder
            // Configures the issuer (iss claim)
            ->issuedBy('http://' . $_SERVER['SERVER_NAME'])
            // Configures the audience (aud claim)
            ->permittedFor('http://' . $_SERVER['SERVER_NAME'])
            // Configures the subject of the token (sub claim)
            ->relatedTo('component1')
            // Configures the id (jti claim)
            ->identifiedBy('4f1g23a12aa')
            // Configures the time that the token was issue (iat claim)
            ->issuedAt($now)
            // Configures the time that the token can be used (nbf claim)
            ->canOnlyBeUsedAfter($now->modify('+1 minute'))
            // Configures the expiration time of the token (exp claim)
            ->expiresAt($now->modify('+1 hour'))
            // Configures a new claim, called "uid"
            ->withClaim('uid', $obj->uuid)
            // Configures a new header, called "foo"
            ->withHeader('foo', 'bar')
            // Builds a new token
            ->getToken($algorithm, $signingKey);
 
        $tokenObj = PersonalAccessToken::create([
            'tokenable_type' => 'jwt',
            'tokenable_id' => $obj->id,
            'name' => $obj->email,
            'token' => $token->toString(),
            'abilities' => 'admin, web',
            'expires_at' => $now->modify('+1 hour'),
            'last_used_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);
        $saved = $tokenObj->save();
        return $token->toString();
    }

    // private function validateToken($obj){
    //     $parser = new Parser(new JoseEncoder());

    //     $token = $parser->parse(
    //         'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImZvbyI6ImJhciJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0IiwiYXVkIjoiaHR0cDovL2xvY2FsaG9zdCIsInN1YiI6ImNvbXBvbmVudDEiLCJqdGkiOiI0ZjFnMjNhMTJhYSIsImlhdCI6MTcyMDQxMjE0MS42NjE0OTUsIm5iZiI6MTcyMDQxMjIwMS42NjE0OTUsImV4cCI6MTcyMDQxNTc0MS42NjE0OTUsInVpZCI6IjRjZWI3NDQyLTA4ZTYtNDY1My05MmE5LWU3ZmE4ZmQ0ZDc0MiJ9.8rYUC6J5oYzR19HElst1M2_ZXsT1PqzZ7_FEMpWTylI'
    //     );
        
    //     $validator = new \Lcobucci\JWT\Validation\ValidatorValidator();
        
    //     try {
    //         $validator->assert($token, new RelatedTo('1234567891')); // doesn't throw an exception
    //         $validator->assert($token, new RelatedTo('1234567890'));
    //     } catch (RequiredConstraintsViolated $e) {
    //         // list of constraints violation exceptions:
    //         var_dump($e->violations());
    //     }
    // }

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

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();

        $email = $input['email'];
        $password = $input['password'];

        $obj = User::where('email', $email)->first();
        if(!empty($obj)){
            $check = Hash::check($password, $obj->password);
            if($check){
                $jwtToken = ['token' => $this->generateToken($obj)];
                // $this->validateToken($obj);
                return response(['data' => $jwtToken, 'message' => 'user login successful, token generated', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
            }
        }else{
            return response(['data' => [], 'message' => 'email and password combination incorrect', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }

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