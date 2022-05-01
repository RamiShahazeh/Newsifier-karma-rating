<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Http\Requests\User\GetUserRequest;
use App\Services\UserService;
use Exception;

class UserController extends Controller
{
    public function get_user_position(Request $request)
    {
        return view('users', ['users' =>[]]);
    }

    public function post_user_position(GetUserRequest $request)
    {
        try{
            $result = $request->validated();
            
            isset($request->limit) ?
            $data = UserService::get_user_position($request->user_id, $request->limit):
            $data = UserService::get_user_position($request->user_id);
        
            return view('users', ['users' =>$data, 'user_id'=>$request->user_id, 'limit'=> $request->limit]);
        }catch(Exception $e){
            return view('users', ['users' =>[]])->with('error_message',$e->getMessage());
        }
    }

    

}
