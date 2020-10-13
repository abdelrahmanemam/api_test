<?php

namespace App\Http\Controllers\API;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStore;
use Illuminate\Http\Request;

class AdminRegisterController extends Controller
{
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function register(UserStore $request)
    {
        $request->offsetSet('password', bcrypt($request->get('password')));

        $this->admin->create($request->all());

        $success['token'] =  $this->admin->createToken('MyApp')->accessToken;
        $success['name'] =  $this->admin->name;
        return response(['success'=>$success]);
    }
}
