<?php

namespace App\Http\Controllers\API;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginStore;
use App\Http\Requests\UserStore;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoggingController extends Controller
{

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin-api')->except('logout');
    }

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';


    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function login(LoginStore $request)
    {
        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response(['success' => $success]);
        }
        else{
            return response(['error'=>'Unauthorised', 401]);
        }
    }

    public function adminLogin(LoginStore $request)
    {
        $email = $request['email'];
        $password = $request['password'];
        $admin = Admin::where('email', $email)->first();
        if($admin){
            $success['token'] =  $admin->createToken('MyApp')-> accessToken;
            return response(['success' => $success]);
        }

        return response(['error'=>'Unauthorised']);
    }


}
