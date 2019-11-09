<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Images;
use Validator;

class ImageController extends Controller
{	
	public function getImages($productid){
        $images = Images::where('images_product_id_foreign', '=', $productid)->get();

        return response()->json($images);
    }

    public function store($productid, Request $request){
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
  
        $Images = new Images;
        $Images->images_product_id_foreign = $productid;


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

    	return response()->json($Images, 200);
    }

     public function update(Request $request, $id){
    	$images = Images::find($id);
    	
    	if(empty($images)){
    		return response()->json(
                [
                    'error' => 'not exists'
                ], 204);
    	}
    	
    	if($request->hasFile('url')){
            $file = $request->file('url');
            $name = $file->getClientOriginalName();
            
            $img = str_random(5)."_".$name;
            while (file_exists("Images/".$img)) {
                $img = str_random(5)."_".$name;
            }

            $file->move("Images", $img);

            $images->url = $img;
        }

    	$images->update();

    	return response()->json($images, 200);
    }

     public function delete($id) {
    	$images = Images::find($id);
    	$images->delete();

    	return response()->json(['success' => 'deleted'], 200);
    }
   
}
