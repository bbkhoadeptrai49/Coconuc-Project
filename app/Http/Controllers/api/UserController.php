<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Shops;
use App\Products;
use Validator;
use Cloudder;
use Auth;

class UserController extends Controller
{
    public $successStatus = 200;

    public function index(){
        
        $user_arr = User::all();

       	foreach ($user_arr as $user) {
       		if($user['url_images'] != null) {
       			$img = Cloudder::show('avatar/'.$user->url_images);
       			$user->url_images = $img;
       		}
       	}

        return response()->json($user_arr);
    }

    public function login()
    {   
        
        if (Auth::attempt(
            [
                'email' => request('email'),
                'password' => request('password')
            ]

        )) {
            $user = Auth::user();
            // $success['token'] = $user->createToken('token')->accessToken;
            while (Shops::where('shops_user_id_foreign', $user->id)->exists()) {
                $shop = Shops::where('shops_user_id_foreign', $user->id)->first();
                return response()->json(
                [
                    'success' => 'successfully',
                    'userid' => $user->id,
                    'shopID' => $shop->id
                ],
                200
                
                );
            }
            


            return response()->json(
                [
                    'success' => 'successfully',
                    'userid' => $user->id,
                    'shopID' => false
                ],
                200
                
            );
        }
        else {
            return response()->json(
                [
                    'faile' => 'Unauthorised'
                ], 400);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'c_password' => 'required|same:password',
                'phone' => 'required|min:10'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ], 400);
        }

        while (User::where('email', $request->email)->exists()) {
            return response()->json(
                [
                    'error' => 'email really exists'
                ], 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        
        $user = new User;
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->phone = $input['phone'];
        $user->birthday = $input['birthday'];
        $user->sex = $input['sex'];
        $user->url_images = $input['sex'] == 0 ? 'nvTa3_female-define_jjhyfx' : 'male-define_ubnxt4';
        $user->save();

        // $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        return response()->json(
            [
                'status' => true
            ],
            $this->successStatus
        );

    }

    public function getUser($id){
    	$user = User::find($id);
    	$user->url_images = Cloudder::show('avatar/'.$user->url_images);
        return response()->json($user);
    }

    public function update(Request $request, $id){
        $user = User::find($id);
        
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'phone' => 'required|min:10'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ], 400);
        }


        $input = $request->all();
        $user->name = $input['name'];
        $user->phone = $input['phone'];
        $user->birthday = $input['birthday'];
        $user->sex = $input['sex'];

        if($request->hasFile('url_images')){
            $file = $request->file('url_images');
            $name = $file->getClientOriginalName();
            
            $img = str_random(5)."_".$name;
            Cloudder::upload($file, 'avatar/'.$img);
            $user->url_images = $img;
        } 

        $user->update();
       
        return response()->json(['status'=> true], $this->successStatus);
    }

    public function createShop($userid, Request $request){
        $validator = Validator::make($request->all(),
            [
                'shop_name' => 'required',
               
            ]
        );

        while (Shops::where('shops_user_id_foreign', $userid)->exists()) {
            return response()->json(
                [
                    'error' => 'You have a shop'
                ], 400);
        }

        $shop = new Shops;
        $shop->shop_name = $request['shop_name'];
        $shop->shops_user_id_foreign = $userid;
        $shop->save();

        return response()->json(['shop' => $shop, 'status' => true]);        
    }

    public function getShop($user){

    	while (Shops::where('shops_user_id_foreign', $user)->exists()) {
            $info = Shops::where('shops_user_id_foreign', $user)->first();
        	$product = Products::where('products_shop_id_foreign', '=', $info->id)->get();

 	        return response()->json(['info' => $info , 'products' => $product]);

        }
    	
    	 return response()->json(['status' => false], 400);
    }
}
