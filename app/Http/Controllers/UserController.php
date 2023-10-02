<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRegisterUser;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
     // register user
     public function register(CreateRegisterUser $request) {
        // get data request
        $data = $request->validated();

        // check email
        if(User::where('email', $request['email'])->count() == 1){
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

        // save usesr
        $user = new User($data);
        // hash password
        $user->password = Hash::make($data['password']);
        $user->save();

        // send response message
        return response()->json([
            'message' => 'User register sucessfully...'
        ], 200);
    }

    // get current user
    public function getCurrentUser(Request $request): UserResource{
        // check current user
        $user = Auth::user();

        return new UserResource($user);
    }

    // update user
    public function updateUser(UpdateUserRequest $request){
        // get current user
        $currentUser = Auth::user();

        // validate request
        $data = $request->validated();

        // get user from table user by token
        $user = User::where('token', $currentUser['token'])->first();

        // validate user
        if(!$user){
            return response()->json([
                'error' => "User Not Found"
            ], 404);
        }

        // update user
        if(isset($data['name'])){
            $user->name = $data['name'];
        }

        if(isset($data['email'])){
            $user->email = $data['email'];
        }

        if(isset($data['phone'])){
            $user->phone = $data['phone'];
        }

        if(isset($data['address'])){
            $user->address = $data['address'];
        }

        // save user
        $user->save();

        return response()->json([
            'message' => 'User updated sucessfully...'
        ], 200);
    }

    // user login
    public function login(UserLoginRequest $request){
        // get data request
        $data = $request->validated();

        // select email and password from database
        $user = User::where('email', $data['email'])->first();
        if(!$user || !Hash::check($data['password'], $user->password)){
            // return response unautorized
            throw new HttpResponseException(response([
                'error' => 'Email or Password not registered!'
            ], 401));
        }

        // create random token login
        $tokenLogin = Str::uuid()->toString();

        // save token login
        $user->token = $tokenLogin;
        $user->save();

        // send response with token
        return response()->json([
            'status' => true,
            'token' => $tokenLogin
        ], 200);
    }


    // user logout
    public function logout(Request $request){
        // get current admin
        $user = Auth::user();

        // get token user from table user
        $user = User::where('token', $user['token'])->first();

        // set back token to null
        $user->token = null;

        // save user
        $user->save();

        // return response
        return response()->json([
            'status' => true,
            'message' => "Logout..."
        ], 200);
    }
}
