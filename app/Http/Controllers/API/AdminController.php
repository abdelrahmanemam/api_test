<?php

namespace App\Http\Controllers\API;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{


    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
        $this->middleware('auth:admin-api');

    }

    /**
     * admin's all details api
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $admin = Auth::admin();
        return response(['success' => $admin]);
    }
}


