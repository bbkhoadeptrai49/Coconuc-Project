<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class OrderController extends Controller
{
    public function store(){
    	$validator = Validator::make($request->all(),
            [
                'url' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ], 400);
        }
  
       
    }
}
