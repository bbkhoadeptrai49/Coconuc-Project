<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\User;
use Auth;
use Validator;
use App\Products;


class UserController extends Controller
{
    public $successStatus = 200;

    public function index(){
        
        return User::all();
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

            return response()->json(
                [
                    'success' => 'hello'.$user->name
                ],
                
                $this->successStatus
            );
        }
        else {
            return response()->json(
                [
                    'error' => 'Unauthorised'
                ], 401);
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
                ], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        // $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        return response()->json(
            [
                'success' => $success
            ],
            $this->successStatus
        );

    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();

        return response()->json(
            [
                'success' => $user
            ],
            $this->successStatus
        );
    }

    public function getShop($user){
        $product = Products::find(1)->where('products_user_id_foreign', '=', $user)->get();

        return response()->json($product);
    }

    public function getUser($id){
        return User::find($id);
    }

    public function createShop($id, Request $request){
        $validator = Validator::make($request->all(),
            [
                'shops' => 'required',
               
            ]
        );

        $user = User::find($id);
        $user->shops = $request['shops'];
        $user->save();

        return response()->json($user);        
    }

    public function update(Request $request, $id){
        $user = User::find($id);
        
        $validator = Validator::make($request->all(),
            [
                
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ], 400);
        }


        $input = $request->all();
        $user->update($input);

        return response()->json($user);
    }

}
