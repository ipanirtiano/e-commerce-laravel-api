<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // register admin
    public function register(CreateAdminRequest $request) {
        // get data request
        $data = $request->validated();

        // check email
        if(Admin::where('email', $request['email'])->count() == 1){
            // return message response
            throw new HttpResponseException(response([
                'error' => 'Email already taken!'
            ], 400));
        }

        // check password and confirm password
        if($data['password'] != $data['confirmPassword']){
            // return message response
            throw new HttpResponseException(response([
                'error' => 'Password not match!'
            ], 400));
        }

        // save admin
        $admin = new Admin($data);
        // hash password
        $admin->password = Hash::make($data['password']);
        $admin->save();

        // send response message
        return response()->json([
            'message' => 'Admin register sucessfully...'
        ], 200);
    }


    // admin login
    public function login(AdminLoginRequest $request){
        // get data request
        $data = $request->validated();

        // select email and password from database
        $admin = Admin::where('email', $data['email'])->first();
        if(!$admin || !Hash::check($data['password'], $admin->password)){
            // return response unautorized
            throw new HttpResponseException(response([
                'error' => 'Email or Password not registered!'
            ], 401));
        }

        // create random token login
        $tokenLogin = Str::uuid()->toString();

        // save token login
        $admin->token = $tokenLogin;
        $admin->save();

        // send response with token
        return response()->json([
            'status' => true,
            'token' => $tokenLogin
        ], 200);
    }


    // get current admin
    public function getCurrentAdmin(Request $request): AdminResource{
        // check current admin
        $admin = Auth::user();

        return new AdminResource($admin);
    }


    // admin logout
    public function logout(Request $request){
        // get current admin
        $admin = Auth::user();

        // get token admin from table admin
        $admin = Admin::where('token', $admin['token'])->first();

        // set back token to null
        $admin->token = null;

        // save admin
        $admin->save();

        // return response
        return response()->json([
            'status' => true,
            'message' => "Logout..."
        ], 200);
    }
}
