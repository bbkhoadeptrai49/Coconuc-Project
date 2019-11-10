<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Products;
use App\Images;
use Cloudder;

class ProductController extends Controller
{
    public function index(){
    	$product = Products::all();
        return response()->json($product);
    }

    public function show($id){
    	$product = Products::find($id);
    	$img_arr = Images::where('images_product_id_foreign', $id)->get();
    	foreach ($img_arr as $image) {
       		if($image['url'] != null) {
       			$img = Cloudder::show('images/'.$image->url);
       			$image->url = $img;
       		}
       	}

    	return response()->json(['info' => $product, 'images' => $img_arr]);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(),
            [
                'product_name' => 'required|min:2|max:190',
                'description' => 'required|min:10',
                'price' => 'required|numeric',
                'url' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ], 400);
        }

        $product = Products::create($request->all());
        $Images = new Images;
        $Images->images_product_id_foreign = $product->id;


        if($request->hasFile('url')){
            $file = $request->file('url');
            $name = $file->getClientOriginalName();
            
            $img = str_random(5)."_".$name;
           	Cloudder::upload($file, 'Images/'.$img);
            $Images->url = $img;
        
        } else {
            $Images->url = 'no-image_bi4whx';
        }

        $Images->save();

    	return response()->json(['status' => true]);
    }
	

    public function update(Request $request, $id){
    	$product = Products::find($id);
    	
        $validator = Validator::make($request->all(),
            [
                'product_name' => 'required|min:2|max:190',
                'price' => 'required|numeric',
                'quantity' => 'required|numeric',
                'description' => 'required|min:10'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ], 400);
        }

    	if(empty($product)){
    		return response()->json(['status' => false]);
    	}


    	$input = $request->all();
    	$product->update($input);

    	return response()->json(['status'=>true]);
    }


    public function delete($id) {

    	while (Images::where('images_product_id_foreign', $id)->exists()) {
            return response()->json(
                [
                    'status' => false
                ], 400);
        }

    	$product = Products::find($id);
    	$product->delete();

    	return response()->json(['status' => true], 200);
    }

    public function getByType($typeid){
        $product_list = Products::where('products_type_id_foreign', $typeid)->get();
        return response()->json($product_list);
    }

    public function getByShop($shopid){
        $product_list = Products::where('products_shop_id_foreign', $shopid)->get();
        return response()->json($product_list);
    }

    public function getByCategory($categoryid){
        $product_list = Products::join('types', 'products.products_type_id_foreign', '=', 'types.id')->join('categories', 'categories.id', '=', 'types.types_categories_id_foreign')->where('categories.id', $categoryid)->get();
        return response()->json($product_list);
    }


}
