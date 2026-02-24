<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Quest;

class EventController extends Controller
{
   public function getActiveEvents()
    { 
        $now = Carbon::now();

       
        $events = Event::with('quests') 
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->get();

        return $this->success($events, 'Events retrieved successfully');
    }

    public function buyPrize(Request $request, $questId)
    {
        $user = $request->user();
        $quest = Quest::with('event')->findOrFail($questId);

       
        if (Carbon::now()->gt($quest->event->end_date)) {
            return $this->error('Sorry, this event has already ended. Better luck next time!');
        }

   
        if ($user->quests()->where('quest_id', $questId)->exists()) {
            return $this->error('You already have this prize, my friend!');
        }

   
        if ($user->gold < $quest->price) {
            return $this->error('Your gold is not enough!');
        }

        DB::transaction(function () use ($user, $quest) {
            $user->decrement('gold', $quest->price); 
            $user->quests()->attach($quest->id); 
        });

        return $this->success(null, "Congratulations! You've successfully obtained {$quest->prize_name}");
    }
}
