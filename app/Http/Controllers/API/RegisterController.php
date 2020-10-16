<?php

namespace App\Http\Controllers\API;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStore;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */

    public function register(UserStore $request)
    {
        $email = $request->only('email');

        $exist = DB::select('SELECT * FROM `users` WHERE `email`= :email',['email'=>$email['email']]);

        if($exist){ return response(['error'=>'email used']);}
        $request->offsetSet('password', bcrypt($request->get('password')));

        $this->user->create($request->all());

        $success['token'] =  $this->user->createToken('MyApp')->accessToken;
        $success['name'] =  $this->user->name;
        return response(['success'=>$success]);
    }



}
