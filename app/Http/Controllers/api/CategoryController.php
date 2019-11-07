<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Categories;
use App\Auth;
use Validator;

class CategoryController extends Controller
{
    
    public function index(){
    	return Categories::all();
    }
   	
    public function show($id){
    	return Categories::find($id);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(),
            [
                'category_name' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ], 400);
        }

        while (Categories::where('category_name', $request['category_name'])->exists()) {
        	return response()->json(
                [
                    'error' => 'is exists'
                ], 204);
        }
        $category = Categories::create($request->all());

    	return response()->json($category, 201);
    }
	

    public function update(Request $request, $id){
    	$category = Categories::find($id);
    	
        $validator = Validator::make($request->all(),
            [
                'category_name' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ], 400);
        }

    	if(empty($category)){
    		return response()->json(
                [
                    'error' => 'not exists'
                ], 204);
    	}

    	$input = $request->all();
    	$category->update($input);

    	return $category;
    }

    public function delete(Request $request, $id) {
    	$category = Categories::find($id);
    	$category->delete();

    	return 204;
    }
}
