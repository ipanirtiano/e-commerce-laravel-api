<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewAddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    // controller add new address
    public function addNewAdress(AddNewAddressRequest $request) {
        // get current user
        $user = Auth::user();

        // validate request 
        $data = $request->validated();

        // initial new address
        $address = new Address($data);
        $address->id_user = $user['id'];

        // save address
        $address->save();

        // response 
        return response()->json([
            'message' => 'Add new Address successfully'
        ], 200);
    }

    // get address
    public function getAddress(){
        // get current user
        $user = Auth::user();

        // get addres by user ID
        $address = Address::where("id", $user['id'])->get();

        // response
        return response()->json([
            'data' => $address
        ], 200);
    }
}
