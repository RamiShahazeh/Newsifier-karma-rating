<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Http\Requests\User\GetUserRequest;
use App\Services\UserService;
use Exception;
use Validator;

class UserController extends Controller
{
    public function get_user_position(Request $request, $user_id): \Illuminate\Http\JsonResponse
    {
        try{
            // I prefer passing the id in query paramaters to be able to separate 
            // the parameters validation in Requests.

            $validator = Validator::make(['user_id' => $user_id, 'limit'=>$request->limit],[
                'user_id' => 'required|integer|exists:users,id',
                'limit' => 'nullable|numeric|min:1|max:10000000'
              ]);

            if ($validator->fails()) {
                return $this->sendError(__('validation.exists', ['attribute' => 'user id']), 400);
            }

            $data = UserService::get_user_position($user_id, $request->limit);
            
            return $this->sendResponse('', $data);
        }catch(Exception $e){
            return $this->sendError($e->getMessage(), 500);
        }
    }

}
