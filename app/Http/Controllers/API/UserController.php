<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(Request $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $this->user->create($input);


        $success['token'] =  $this->user->createToken('MyApp')->accessToken;
        $success['name'] =  $this->user->name;
        return response()->json(['success'=>$success], $this->successStatus);
    }

    /**
    * login api
    *
    * @return \Illuminate\Http\Response
    */

    public function login(Request $request){

        if(Auth::attempt($request)){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }


    /**
     * user's all details api
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }
}
