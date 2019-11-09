<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Products;
use App\Images;
use App\Categories;
use Validator;

class ProductController extends Controller
{
   
	
   	public function index(){
        return Products::all();
    }

    public function show($id){
    	return Products::find($id);
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
            while (file_exists("Images/".$img)) {
                $img = str_random(5)."_".$name;
            }

            $file->move("Images", $img);

            $Images->url = $img;
        
        } else {
            $Images->url = 'CYrBY_ac1.png';
        }

        $Images->save();

    	return response()->json($product, 200);
    }
	

    public function update(Request $request, $id){
    	$product = Products::find($id);
    	
        $validator = Validator::make($request->all(),
            [
                'product_name' => 'required|min:2|max:190',
                'price' => 'required|numeric',
                'quantity' => 'required|numeric'
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

    	return response()->json($product, 200);
    }


    public function delete(Request $request, $id) {
    	$product = Products::find($id);
    	$product->delete();

    	return response()->json([
                    'success' => 'successfully'
                ], 200);
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
