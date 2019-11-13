<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Products;

class SearchController extends Controller
{
    public function searchProduct(Request $request){
    	$key = $request['search'];
    	$product = Products::where('product_name', 'like', "%$key%")->get();

    	return response()->json($product);    
    }

    public function searchProductByNameType(Request $request, $typeid) {
    	$key = $request['search'];
    	$product = Products::where('product_name', 'like', "%$key%")->where('products_type_id_foreign', $typeid)->get();

    	return response()->json($product);    
    }
}
