<?php
namespace App\Http\Controllers;

use App\Models\System_message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemMessageController extends Controller {

public function index(Request $request) {
    $messages = $request->user()->systemMessages()->latest()->get();

    return $this->success($messages, "messages retrieved successfully");
}

public function markAsRead(Request $request, $id) {
    $request->user()->systemMessages()->updateExistingPivot($id, [
        'is_read' => true
    ]);
    return $this->success(null, "message marked as read successfully");
}
}