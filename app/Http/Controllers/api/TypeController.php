<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Types;
use Validator;
use App\Auth;

class TypeController extends Controller
{
    public function index(){
    	return Types::all();
    }

     public function show($id){
    	return Types::find($id);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(),
            [
                'type_name' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ], 400);
        }
    	// acti select category


    	while (Types::where('type_name', $request['type_name'])->exists()) {
        	return response()->json(
                [
                    'error' => 'is exists'
                ], 204);
        }

        $input = $request->all();
        $type = Types::create($input);
    	return response()->json($type, 201);
    }
	

    public function update(Request $request, $id){
    	$type = Types::find($id);
    	
    	if(empty($type)){
    		return response()->json(
                [
                    'error' => 'not exists'
                ], 204);
    	}

    	$input = $request->all();
    	$type->update($input);

    	return $type;
    }

    public function delete(Request $request, $id) {
    	$type = Types::find($id);
    	$type->delete();

    	return 204;
    }

    public function getByCategory($category){
    	$type = Types::where('types_categories_id_foreign', $category)->get();
    	return response()->json($type);
    }

}
