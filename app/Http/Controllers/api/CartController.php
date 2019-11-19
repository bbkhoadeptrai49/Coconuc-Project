<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Products;
use App\Images;
use App\Shops;
use App\User;
use App\Carts;
use Cloudder;

class CartController extends Controller
{
    public function store(Request $request, $userid, $productid){
    	
    	if(Products::where('id', $productid)->exists() && User::where('id', $userid)->exists()) {
	    	
    		if(Carts::where('carts_product_id_foreign', $productid)->where('status','=', 0)->exists()){
    			$cart = Carts::where('carts_product_id_foreign', $productid)->where('status','=', 0)->first();

    			$quantity = $cart->quantity + $request['quantity'];
    			$cart->quantity = $quantity;
    			$cart->update();

    			return response()->json(['status' => true]);
    		}

	    	$product = Products::where('id', $productid)->first();
	    	$shop = Shops::where('id', $product->products_shop_id_foreign)->first();
	    	$img = Images::where('images_product_id_foreign', $productid)->first();

	    	$cart = new Carts;
	    	$cart->product_name = $product->product_name;
	    	$cart->price = $product->price;
	    	$cart->providers = $shop->shop_name;
            if($img != null){
                $cart->url = $img->url;
            } else {
                $cart->url = 'no-image_bi4whx';
            }

	    	$cart->quantity = $request['quantity'];
	    	$cart->carts_user_id_foreign = $userid;
	    	$cart->carts_product_id_foreign = $productid;
	    	$cart->status = 0;
	    	$cart->save();

	    	return response()->json(['status' => true]);
    	}

    	return response()->json(['status' => false]);
    }

    public function cartDeleteItem($userid, $productid) {
    	while (Carts::where('carts_product_id_foreign', $productid)->where('carts_user_id_foreign', $userid)->exists()) {
    		$item = Carts::where('carts_product_id_foreign', $productid)->where('carts_user_id_foreign', $userid)->where('status', '=', 0)->first();
	    	$item->status = 2;
	    	$item->update();
	    	return response()->json(['status' => true]);
    	}
    	
    	return response()->json(['status' => false]);
    }

    public function cartUpdateItem(Request $request, $userid, $productid) {
    	
    	while (Carts::where('carts_product_id_foreign', $productid)->where('carts_user_id_foreign', $userid)->exists()) {
    		$item = Carts::where('carts_product_id_foreign', $productid)->where('carts_user_id_foreign', $userid)->where('status', '=', 0)->first();

    		$quantity = $request['quantity'];
    		$item->quantity = $quantity;
    		$item->update();

    		return response()->json(['status' => true]);
    	}

    	return response()->json(['status' => false]);
    }

    public function show($userid) {
    	$cart_arr = Carts::where('carts_user_id_foreign', $userid)->where('status', '=', 0)->get();
        if($cart_arr != null) {
            foreach ($cart_arr as $cart) {    
                $img = Cloudder::show('images/'.$cart->url);
                $cart->url = $img;
            }
            return response()->json($cart_arr);
        }

    	return response()->json(['status' => flase]);
    }

    public function cartPay($userid){
    	while (Carts::where('carts_user_id_foreign', $userid)->where('status', '=', 0)->exists()) {
    		$cart = Carts::where('status', '=', 0)->get();
	    	if($cart != null) {
	    		foreach ($cart as $item) { 
	                $item->status = 1;
	                $item->save();
	            }
	    	}

	    	return response()->json(['status' => true]);

    	}
    	return response()->json(['status' => false]);
    }
}
