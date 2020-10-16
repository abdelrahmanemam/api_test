<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginStore;
use App\Http\Requests\UserStore;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * user's all details api
     *
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
        $user = Auth::user();
        return response()->json(['success' => $user]);
    }

    public function logout()
    {
        if (!Auth::check()) {
            return response('you need to sign in first');
        } else {

        DB::table('oauth_access_tokens')
            ->where('user_id', Auth::user()->id)
            ->update([
                'revoked' => true
            ]);
    }
    }


    public function refresh()
    {
//     a
        $row = DB::select(
            'SELECT `id` FROM `oauth_access_tokens`
                    WHERE `user_id` = :id AND TIMESTAMPADD(second , 15 , `expires_at`) <= NOW()
                    ORDER BY `expires_at` DESC LIMIT 1', ['id' => Auth::user()->id]
        );
        $expired_id = $row[0]->id;

        if ($expired_id) {

            DB::table('oauth_access_tokens')
                ->where('id', $expired_id)
                ->delete();

            return response('token expired');
        }

    }
}
