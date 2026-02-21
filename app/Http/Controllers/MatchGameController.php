<?php

namespace App\Http\Controllers;

use App\Models\MatchGame;
use App\Http\Requests\StoreMatchhRequest;
use App\Http\Requests\UpdateMatchhRequest;
use Illuminate\Support\Facades\DB;

class MatchGameController extends Controller
{



    public function endmatch($matchid){
        $match=MatchGame::with('players')->findOrFail($matchid);

        DB::transaction(function() use ($match) {
            foreach($match->players as $player) {
                $user = $player; 
                $pivotData = $player->pivot;

                
                $user->gold += $pivotData->gold_gained;
                $user->gems += $pivotData->gems_gained;
                $user->experience += $pivotData->experience_gained;

                if($pivotData->rank == 1) {
                    $user->wins += 1;
                } else {
                    $user->loses += 1;
                }

                $user->save();
            }
            
        });
     
    }







    
}