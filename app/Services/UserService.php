<?php
namespace App\Services;

use App\Models\Chat;
use App\Models\User;
use App\Events\ChatEvent;
use Illuminate\Support\Facades\Auth;

class UserService{
    public function getUser($user_id)
    {
       return  $reciver_user=User::where('id',$user_id)->first();
    }


    public function send_message($user_id,array $input_data)
    {
        $sender_auth=Auth::user()->id;
        $reciver=User::where('id',$user_id)->first();
        $message=Chat::create([
            'sender_id' => $sender_auth,
            'receiver_id'=> $reciver->id,
            'message' =>$input_data['message']

        ]);
$reciver_id=$reciver->id;
        \broadcast(new ChatEvent($reciver_id,$message));

        return $message;
    }
}








?>
