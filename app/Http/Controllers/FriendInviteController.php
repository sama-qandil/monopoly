<?php

namespace App\Http\Controllers;

use App\Models\Friend_invite;
use Illuminate\Http\Request;

class FriendInviteController extends Controller
{
    public function sendfriendinvites(Request $request)
    {
        $user = $request->user();
        $receiverId = $request->receiver_id;

        $invite = Friend_invite::create([
            'sender_id' => $user->id,
            'receiver_id' => $receiverId,
            'status' => 'pending',
        ]);

        return $this->success($invite, 'Friend invite sent successfully');
    }

    public function Acceptinvite(Request $request, $senderId)
    {
        $user = $request->user();

        $invite = Friend_invite::where('receiver_id', $user->id)
            ->where('sender_id', $senderId)
            ->where('status', 'pending')
            ->first();

        if ($invite) {
            $invite->update(['status' => 'accepted']);

            return $this->success($invite, 'Friend invite accepted successfully');
        }

        return $this->error(null, 'Friend invite not found');
    }

    public function Declineinvite(Request $request, $senderId)
    {
        $user = $request->user();

        $invite = Friend_invite::where('receiver_id', $user->id)
            ->where('sender_id', $senderId)
            ->where('status', 'pending')
            ->first();

        if ($invite) {
            $invite->update(['status' => 'declined']);

            return $this->success($invite, 'Friend invite declined successfully');
        }

        return $this->error(null, 'Friend invite not found');
    }
}
