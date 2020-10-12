<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginStore;
use App\Http\Requests\UserStore;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(UserStore $request)
    {

        //asd
        $request->offsetSet('password', bcrypt($request->get('password')));

        $this->user->create($request->all());

        //asasa
        $success['token'] =  $this->user->createToken('MyApp')->accessToken;
        $success['name'] =  $this->user->name;
        return response()->json(['success'=>$success]);
    }

    /**
    * login api
    *
    * @return \Illuminate\Http\Response
    */

    public function login(LoginStore $request){

        if(Auth::attempt($request->all())){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success]);
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
        return response()->json(['success' => $user]);
    }
}
