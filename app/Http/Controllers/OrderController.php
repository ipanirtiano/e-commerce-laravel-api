<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewOrderRequest;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    
    // add new order
    public function addNewOrder(AddNewOrderRequest $request){
        date_default_timezone_set('Asia/Jakarta');
        // get current user
        $user = Auth::user();

        // get validated request
        $data = $request->validated();

        // set random uuid
        $uuid = "ODR-" . Str::random(10);

        // set date
        $day = date("l");
        $date = date("d-M-Y");
        $hours = date("H:i");
        $orderDate = $day . ", " . $date . " " . $hours;

        // set new initial Order
        $order = new Order($data);
        // set id User
        $order->id_user = $user['id'];
        // set random uuid order
        $order->uuid = $uuid;
        // set date order
        $order->date = $orderDate;
        // set package
        $order->package = 'Pending';
        // set status order
        $order->status = 'Unpaid';

        // save order
        $order->save();


        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-BhT-gj5YKYRXEBda1jMJU9PN';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->uuid,
                'gross_amount' => $order->amount,
            ),
            'customer_details' => array(
                'name' => $order->name,
                'phone' => $order->phone,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken,   
        ],200);
    }


    // get order controller
    public function getAllOrder(){
        // get current user
        $user = Auth::user();

        // get order by ID user
        $order = Order::where("id_user", $user['id'])->orderBy("id", "desc")->get();

        // return all order
        return response()->json([
            'data' => $order
        ], 200);
    }

    // get order by ID
    public function getOrderById($uuid) {
        // get order by ID
        $order = Order::where("uuid", $uuid)->first();

        // validate order
        if(!$order){
            // return message response
            throw new HttpResponseException(response([
                'error' => 'Order Not Found!'
            ], 404));
        }

        // return response
        return response()->json([
            'data' => $order
        ],200);
    }
}
