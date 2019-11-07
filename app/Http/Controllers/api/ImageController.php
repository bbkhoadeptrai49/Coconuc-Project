<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Images;

class ImageController extends Controller
{	
	public function getImages($id){
        $images = Images::find(1)->where('images_product_id_foreign', '=', $id)->get();

        return response()->json($images);
    }
}
