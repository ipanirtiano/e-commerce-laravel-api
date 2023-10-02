<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // add chart
    public function addCart(AddCartRequest $request){
        // get current user
        $user = Auth::user();

        // get request
        $data = $request->validated();

        // check if product already exist in the cart
        $product = Cart::where("id_product", $data['id_product'])->first();


        if($product){
            // update amount cart
            $product->amount = $product->amount + 1;  
            $product->save();
        }else{
            // initial new cart
            $cart = new Cart($data);
            $cart->id_user = $user['id'];

            // save cart
            $cart->save();

            // response 
            return response()->json([
                'message' => 'Add Cart successfully'
            ], 200);
        }

        
    }


    // get all cart
    public function getAllCart(){
        // get current user
        $user = Auth::user();

        // get data cart by ID user
        $carts = Cart::where("id_user", $user['id'])->with("products")->with("photos")->orderBy("id", "desc")->get();

        return response()->json([
            'data' => $carts
        ],200);

    }


    // delete chart
    public function deleteCart($id){

        $cart = Cart::where("id", $id)->delete();

        if(!$cart) {
            return response()->json([
                'message' => "Cart not found!"
            ], 404);
        }

        return response()->json([
            'message' => "Cart deleted succesfully..."
        ], 200);

    }


    // increase amount cart
    public function increaseAmount($id){
        $cart = Cart::where("id", $id)->first();

        if(!$cart) {
            return response()->json([
                'message' => "Cart not found!"
            ], 404);
        }

        $cart->amount = $cart->amount + 1;
        $cart->save();

        return response()->json([
            'message' => "amount added.."
        ], 200);
    }


    // decrease amount cart
    public function decreaseAmount($id){
        $cart = Cart::where("id", $id)->first();

        if(!$cart) {
            return response()->json([
                'message' => "Cart not found!"
            ], 404);
        }

        if($cart->amount == 1){
            return response()->json([
                'message' => "Amount canot decrease anymore!"
            ], 400);
        }

        $cart->amount = $cart->amount - 1;
        $cart->save();

        return response()->json([
            'message' => "amount decrease.."
        ], 200);
    }
}
