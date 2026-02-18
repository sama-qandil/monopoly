<?php
namespace App\Http\Controllers;

use App\Models\System_message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemMessageController extends Controller {

public function broadcastReward(Request $request) {
        $message = System_message::create([
            'title' => $request->title,
            'content' => $request->content,
            'reward_type' => $request->reward_type,
            'reward_amount' => $request->reward_amount,
        ]);

      
        $userIds = User::pluck('id');
        $message->users()->attach($userIds);

        return $this->success(null, "the system message has been broadcasted to all users successfully");
    }

    public function collect(Request $request, $messageId) {
        $user = $request->user();

      
        $message = $user->systemMessages()
                        ->where('system_message_id', $messageId)
                        ->wherePivot('is_collected', false)
                        ->first();

        if (!$message) {
            return $this->error("This system message is not available for collection.");
        }

        DB::transaction(function () use ($user, $message) {
            // تحديث رصيد اللاعب
            $user->increment($message->reward_type, $message->reward_amount);

            // تحديث حالة التحصيل في الجدول الوسيط (Pivot) لهذا اللاعب فقط
            $user->systemMessages()->updateExistingPivot($message->id, [
                'is_collected' => true
            ]);
        });

        return $this->success([
            'gold' => $user->gold,
            'gems' => $user->gems
        ], "!You have successfully collected the reward from the system message");
    }
}