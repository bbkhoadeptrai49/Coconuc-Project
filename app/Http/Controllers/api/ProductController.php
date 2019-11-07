<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Products;
use Validator;

class ProductController extends Controller
{
   
	
   	
    public function show($id){
    	return Products::find($id);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(),
            [
                'product_name' => 'required|min:2|max:190',
                'description' => 'required|min:10',
                'price' => 'required|numeric'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ], 400);
        }

        $product = Products::create($request->all());

    	return response()->json($product, 201);
    }
	

    public function update(Request $request, $id){
    	$product = Products::find($id);
    	
        $validator = Validator::make($request->all(),
            [
                'product_name' => 'required|min:2|max:190',
                'price' => 'required|numeric'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ], 400);
        }

    	if(empty($product)){
    		return response()->json(
                [
                    'error' => 'not exists'
                ], 204);
    	}

    	$input = $request->all();
    	$product->update($input);

    	return $product;
    }

    public function delete(Request $request, $id) {
    	$product = Products::find($id);
    	$product->delete();

    	return 204;
    }
    
}
