<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Resources\ChatResource;
use App\Http\Resources\UserResource;
use App\Http\Requests\SendChatRequest;

class ChatController extends Controller
{
    //

   public function chatform($user_id,UserService $userService){
     $reciver= $userService->getUser($user_id);
      return response()->json([
           'status' =>'reciver ',
           'user'=>new UserResource($reciver)
      ]);

   }

   //send Message
   public function sendMessage(SendChatRequest $request,$user_id,UserService $userService){
    $input_data=$request->validated();
         $message= $userService->send_message($user_id,$input_data);
          return response()->json([
            'status' =>'chat ',
            'resiver' =>new UserResource($userService->getUser($user_id)),
            'user'=>new ChatResource($message)
       ]);
   }

}
