<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    //register
    public function register(Request $req){

        $messages = [
            'unique' => 'انت مسجل من قبل',
          ];

            // $fileds=$req->validate([
            //     'name'=>'required|string',
            //     'mobile_phone'=>'required|numeric|digits:11|unique:users',
            //     'mobile_father'=>'required|numeric|digits:11|unique:users',
            //     'device_id'=>'required|string',
            //     'year_type'=>'required'
            // ],$messages);

            if(User::where('mobile_phone',$req->mobile_phone)->exists()||User::where('device_id',$req->device_id)->exists()){
                return response(
                    ['message'=>'انت مسجل من قبل ',
                     'status'=> false,
                     'data'=>null]
                ,200);

            }
                else{

                $user=new User;
                $user->name=$req->name;
                $user->mobile_phone=$req->mobile_phone;
                $user->mobile_father=$req->mobile_father;
                $user->device_id=$req->device_id;
                $user->year_type=$req->year_type;
                $user->save();
                $token=$user->createToken('myapptoken')->plainTextToken;



                return response(
                    ['message'=>' تم الدخول بنجاح ',
                     'status'=> true,
                     'data'=>$user,
                     'token'=>$token]
                ,200);
            }

    }
    //login

public function login(Request $req){

    $fields = $req->validate([
        'mobile_phone' => 'required|numeric',
        'device_id' => 'required',
    ]);

    $user = User::where('mobile_phone', $req->mobile_phone)->first();

    if (!$user) {
        return response(
            ['message' => 'رقم الموبايل خطا ',
             'status' => false,
             'data' => null]
        , 401);
    }


    if ($user->device_id == null) {
        // Update the user's device_id with the one from the request
        $user->device_id = $req->device_id;
        $user->save();
    }

        // Check if the device_id from the request matches the user's device_id
        if ($user->device_id != $req->device_id) {
            return response(
                ['message' => 'استخدم الجهاز المسجل بالنظام',
                 'status' => false,
                 'data' => null]
            , 201);
        }


    $token = $user->createToken('myapptoken')->plainTextToken;

    return response(
        ['message' => 'تم الدخول بنجاح ',
         'status' => true,
         'data' => $user,
         'token' => $token,]
    , 200);
}


    public function logout(Request $req){

        if ($req->user()) {
            $req->user()->tokens()->delete();
        }
        return response()->json(['message' => 'logout'], 200);
    }

}
