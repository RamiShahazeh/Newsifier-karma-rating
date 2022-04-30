<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Http\Requests\User\GetUserRequest;
use App\Services\UserService;
use Exception;
use Validator;

class UserController extends Controller
{
    public function get_user_position(Request $request)
    {
        try{
            // I prefer passing the id in query paramaters to be able to separate 
            // the parameters validation in Requests.
            $validator = Validator::make(['user_id' => $request->user_id, 'limit'=>$request->limit],[
                'user_id' => 'required|integer|exists:users,id',
                'limit' => 'nullable|numeric|min:1|max:10000000'
              ]);

            if ($validator->fails()) {
                return view('users', ['users' =>[]]); 
            }

            $data = UserService::get_user_position($request->user_id, $request->limit);
            
            return view('users', ['users' =>$data, 'user_id'=>$request->user_id, 'limit'=> $request->limit]);
        }catch(Exception $e){
            return $this->sendError($e->getMessage(), 500);
        }
    }

}
