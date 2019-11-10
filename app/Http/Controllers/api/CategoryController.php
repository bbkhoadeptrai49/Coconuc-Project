<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Categories;
use Validator;

class CategoryController extends Controller
{
    public $status = true;

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
                    'error' => 'category is exists'
                ], 200);
        }
        $category = Categories::create($request->all());

    	return response()->json([$category, 'status'=> true]);
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
                    'error' => 'category not exists'
                ], 200);
    	}

    	$input = $request->all();
    	$category->update($input);

    	return response()->json(['status' => true]);
    }

    public function delete($id) {
    	
    	while (Categories::where('id', $id)->exists()) {
            $category = Categories::find($id);
    		$category->delete();

    		return response()->json('status', $this->$status);
        }

        return response()->json(['status' => false]);
    }
}
