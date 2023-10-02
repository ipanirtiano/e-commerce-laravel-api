<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Photo_product;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // add new product controller
    public function addProduct(CreateProductRequest $request){
        // get current admin
        $admin = Auth::user();

        // validate request
        $data = $request->validated();

        // initials new Product
        $product = new Product($data);

        // get randoum uuID Product
        $productId = Str::uuid()->toString();
        $product->uuid = $productId;

        // save product
        $product->save();

        // check file image product
        $image = $data['photo_product'];
        $fileName = '';

        // upload file multiple
        foreach($image as $img){
            // set file name image product
            $fileName = Str::random(32).".".$img->getClientOriginalExtension();

            // set path
            $path = 'product/'.$fileName;
            // set storage
            Storage::disk('public')->put($path, file_get_contents($img));

           // initials new Photo Product
           $photoProduct = new Photo_product([
            'id_product' => $product->id,
            'image' => $fileName
           ]);
            $photoProduct->save();
        }

        return response()->json([
            'message' => 'Add new Product sucessfully..'
        ], 200);

    }

    // get all product controller
    public function getAllProduct(Request $request){
        // get all product with image product
        $product = Product::with('photos')->orderBy("id", "desc")->get();

        // return response
        return response()->json([
            'data' => $product
        ], 200);
    }

    // get product by ID
    public function getProductById($uuid){
        // get product by ID product
        $product = Product::where("uuid", $uuid)->with("photos")->first();

        // return response
        return response()->json([
            'data' => $product
        ], 200);
    }


    // update product controller
    public function updateProduct(UpdateProductRequest $request, $uuid){
        // get product by ID
        $product = Product::where("uuid", $uuid)->first();
        // validate product
        if(!$product){
            return response()->json([
                'error' => 'Product not found!'
            ], 404);
        }

        // get request validated
        $data = $request->validated();

        // update product
        if(isset($data['product_name'])){
            $product->product_name = $data['product_name'];
        }
        if(isset($data['categories'])){
            $product->categories = $data['categories'];
        }
        if(isset($data['color'])){
            $product->color = $data['color'];
        }
        if(isset($data['size'])){
            $product->size = $data['size'];
        }
        if(isset($data['storage'])){
            $product->storage = $data['storage'];
        }
        if(isset($data['description'])){
            $product->description = $data['description'];
        }
        if(isset($data['price'])){
            $product->price = $data['price'];
        }

        // save update product
        $product->save();

        return response()->json([
            'message' => 'Product updated sucessfully...'
        ], 200);
    }


    // delete product by ID
    public function deleteProduct($uuid){
        // get product by ID
        $product = Product::where("uuid", $uuid)->first();

        // validate product
        if(!$product){
            return response()->json([
                'error' => 'Product not found!'
            ], 404);
        }

        // get photo product by ID Product
        $photoProduct = Photo_product::where("id_product", $product["id"])->get();

        if($photoProduct){
            // set path
            $path = 'product/'.$photoProduct->image;
            // get public storage
            $storage = Storage::disk('public');
            // delete image product
            if($storage->exists($path)){
                $storage->delete($path);
            }
    
            
            // delete photo product
            $photoProduct->delete();
        }
            
        // delete product
        $product->delete();
    
        return response()->json([
            'message' => 'Product deleted sucessfully...'
        ], 200);

    }
}
