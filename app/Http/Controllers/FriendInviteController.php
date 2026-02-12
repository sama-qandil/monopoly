<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend_invite;
use Illuminate\Support\Facades\DB;

class FriendInviteController extends Controller
{
    public function sendfriendinvites(Request $request){
        $user= $request->user();
        $receiverId= $request->receiver_id;

        $invite=Friend_invite::create([
            'sender_id'=>$user->id,
            'receiver_id'=>$receiverId,
            'status'=>'pending',
        ]);

        $invite->inboxes()->create([
            'user_id'=>$receiverId,
        ]);
        return $this->success($invite, "Friend invite sent successfully");
    }



public function Acceptinvite(Request $request, $senderId) {
    $user = $request->user(); 
    $invite = Friend_invite::where('receiver_id', $user->id)
                           ->where('sender_id', $senderId)
                           ->where('status', 'pending')
                           ->first();

    if ($invite) {
        DB::transaction(function () use ($invite, $user, $senderId) {
          
            $invite->update(['status' => 'accepted']);
            $invite->inboxes()->where('user_id', $user->id)->update(['is_read' => true]);

            $user->friends()->attach($senderId); 
           
        });

        return $this->success($invite, "invite accepted successfully");
    }

    return $this->error(null, "Friend invite not found");
}
    

public function declineinvite(Request $request, $senderId) {
    $user = $request->user(); 
    $invite = Friend_invite::where('receiver_id', $user->id)
                           ->where('sender_id', $senderId)
                           ->where('status', 'pending')
                           ->first();

    if ($invite) {
        DB::transaction(function () use ($invite, $user, $senderId) {
          
            $invite->update(['status' => 'declined']);
            $invite->inboxes()->where('user_id', $user->id)->update(['is_read' => true]);

            $user->friends()->attach($senderId); 
           
        });

        return $this->success($invite, "invite declined successfully");
    }

    return $this->error(null, "Friend invite not found");
}

}
    


