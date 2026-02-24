<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemMessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = $request->user()->systemMessages()
            ->select('system_messages.*') // TODO: no need for this select, this is the default bahvior
            ->withPivot('is_read')
            ->latest()
            ->get();

        return $this->success($messages, 'messages retrieved successfully');
    }

    public function markAsRead(Request $request, $id)
    {
        $request->user()->systemMessages()->updateExistingPivot($id, [
            'is_read' => true,
        ]);

        return $this->success(null, 'message marked as read successfully');
    }
}
