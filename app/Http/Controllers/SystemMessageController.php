<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemMessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = $request->user()->systemMessages()
            ->withPivot('is_read')
            ->latest()
            ->get();

        return $this->success($messages, 'Messages retrieved successfully'); // TODO: use resource
    }

    public function markAsRead(Request $request, $id)
    {
        $request->user()->systemMessages()->updateExistingPivot($id, [
            'is_read' => true,
        ]);

        return $this->success(null, 'message marked as read successfully');
    }
}
